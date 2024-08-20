<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderSlipHeader as ResourcesOrderSlipHeader;
use App\Models\OrderSlipDetail;
use App\Models\OrderSlipHeader;
use App\Services\PrintItemPerLocationService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderSlipConfirmController extends Controller
{
    protected $printItemPerLocationService;

    public function __construct()
    {
        $this->printItemPerLocationService = new PrintItemPerLocationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            DB::beginTransaction();

            $os = OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)
                ->update([
                    'CONFIRMED_AT' => Carbon::now(),
                    'ACCOUNTTYPE' => 1
                ]);

            $os_resource = ResourcesOrderSlipHeader::make(
                OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)->first()
            );

            $osd = OrderSlipDetail::with(['product'])
                ->where('OSNUMBER', $request->orderslip_number)
                ->where('CONFIRMED_AT', null)
                ->get();

            $result = $this->printItemPerLocationService->handle(
                $request->orderslip_number,
                $osd,
                null,
                json_decode( $os_resource->toJson() )->tables
            );

            if(!$result['success']){
                DB::rollBack();
                return response()->json([
                    'message' => $result['message']
                ], 400);
            }

            foreach ($osd as $key => $item) {
                // OrderSlipDetail::where('BRANCHID', $item->BRANCHID)
                //     ->where('ORDERSLIPDETAILID', $item->ORDERSLIPDETAILID)
                //     ->where('ORDERSLIPNO', $item->ORDERSLIPNO)
                //     ->where('DEVICENO', $item->DEVICENO)
                //     ->where('OUTLETID', $item->OUTLETID)
                OrderSlipDetail::where('OSNUMBER', $request->orderslip_number)
                    ->where('DEVICENO', $item->DEVICENO)
                    ->where('OUTLETID', $item->OUTLETID)
                    ->where('PRODUCT_ID', $item->PRODUCT_ID)
                    ->where('SEQUENCE', $item->SEQUENCE)
                    ->where('CONFIRMED_AT', null)
                    ->update([
                        'REQUESTEDQTY' => (int)$item->QUANTITY,
                        'CONFIRMED_AT' => now(),
                        'PSTATUS' => 1
                    ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Ok',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'systemMessage' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
