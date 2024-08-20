<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipHeader;
use App\Services\UpdateOrderslipTotalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChangeOrderTypeController extends Controller
{
    protected $updateOrderslipTotalService;
    public function __construct()
    {
        $this->updateOrderslipTotalService = new UpdateOrderslipTotalService;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // if there is on. make it off
            OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)
                ->update([
                    'OSTYPE' => $request->order_type
                ]);

            $this->updateOrderslipTotalService->handle($request->orderslip_number, $request->order_type);

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
}
