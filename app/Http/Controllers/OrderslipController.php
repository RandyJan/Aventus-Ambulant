<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderSlipHeaderCollection;
use App\Models\OrderSlipHeader;
use App\Services\CartInformationService;
use App\Services\GetCurrentTransactionService;
use App\Services\RemoveCurrentTransactionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderslipController extends Controller
{

    protected $getCurrentTransactionSrvc;
    protected $removeCurrentTransactionSrvc;
    protected $cartSrvc;

    public function __construct()
    {
        $this->getCurrentTransactionSrvc = new GetCurrentTransactionService;
        $this->removeCurrentTransactionSrvc = new RemoveCurrentTransactionService;
        $this->cartSrvc = new CartInformationService;
    }

    public function index(Request $request)
    {

        $items = OrderSlipHeader::with('terminal')
            ->when($request->branch_id, function ($q) use ($request) {
                $q->where('BRANCHID', $request->branch_id);
            })
            ->when($request->outlet_id, function ($q) use ($request) {
                $q->where('OUTLETID', $request->outlet_id);
            })
            ->when($request->hide_completed == true, function ($q) {
                $q->where('QDATE', '=', null);
            })
            ->when($request->show_completed == true, function ($q) {
                $q->where('QDATE', '!=', null);
            })
            ->orderBy('OSDATE', 'desc')
            ->paginate($request->limit);


        return new OrderSlipHeaderCollection($items);
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            // check first for current transaction
            $result = $this->getCurrentTransactionSrvc->handle(
                $request->branch_id,
                $request->user_id
            );

            // if has, make it inactive
            if ($result['success']) {
                $this->removeCurrentTransactionSrvc->handle(
                    $request->branch_id,
                    $request->user_id
                );
            }

            // if there is on. make it off
            OrderSlipHeader::where('DEVICENO', $request->device_id)
                ->where('BRANCHID', $request->branch_id)
                ->where('CUSTOMERDISPLAY', 1)
                ->update([
                    'CUSTOMERDISPLAY' => 0
                ]);
            // end

            // create a new orderslip
            $orderslip_new_id =  OrderSlipHeader::getNewId($request->branch_id, $request->outlet_id, $request->device_id);
            $payload = [
                'ORDERSLIPNO' => $request->orderslip_no,
                'BRANCHID' => $request->branch_id,
                'CUSTOMERNAME'=>$request->customer_name,
                'OUTLETID' => $request->outlet_id,
                'DEVICENO' => $request->device_id,
                'STATUS' => 'X',
                'DISPLAYMONITOR' => 2,
                'ENCODEDBY' => $request->user_id,
                'PREPAREDBY' => $request->user_name,
                'CCENAME' => $request->user_name,
                'TRANSACTTYPEID' => 1,
                'OSDATE' => now(),
                'ORIGINALINVOICEDATE' => getClarionDate(now()),
                'ENCODEDDATE' => now(),
                // 'OSNUMBER' => osNumberGenerator($request->branch_id, $request->device_id, Carbon::parse($request->business_date), $orderslip_new_id),
                // 'OSNUMBER' => osNumberGenerator($request->branch_id, $request->device_id, now(), $orderslip_new_id),
                "OSNUMBER"=> $request->orderslip_no,
                'USER_CURRENT_TRANSACTION' => $request->user_id,
                'BUSDATE' => getClarionDate(now()),
                'PAID' => 0,
                'ACCOUNTTYPE' => 0,

                // 'OSTYPE' => config('settings.default_order_type'),
                // 'SERVICE_CHARGE_AMT' => 0,
                // 'SERVICE_CHARGE_PERCENTAGE' => $request->service_charge_percentage,
            ];

            if (config('settings.app_type') == 'restaurant_ambulant') {
                $payload['OSTYPE'] = config('settings.default_order_type');
                $payload['SERVICE_CHARGE_AMT'] = 0;
                $payload['SERVICE_CHARGE_PERCENTAGE'] = $request->service_charge_percentage;
            }

            OrderSlipHeader::create($payload);

            DB::commit();
            return response()->json([
                'message' => 'Ok',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'system' => $e->getMessage()
            ], 500);
        }
    }

    public function orderslipOverview($orderslip_code)
    {
        try {

            $cart = $this->cartSrvc->handle($orderslip_code);

            return response()->json([
                'message' => 'Ok',
                'data' => $cart['data']
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'SERVER ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function AddNewJO(){
        return view('pages.AddNewJO');
    }
}
