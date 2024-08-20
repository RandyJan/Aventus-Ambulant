<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShellConfirmOrderController extends Controller
{
    public function update($os_number)
    {
        try {
            DB::beginTransaction();

            logger('OS No. ' . $os_number);

            $items = OrderSlipDetail::where('OSNUMBER', $os_number)->get();
            foreach ($items as $key => $item) {
                if (is_null($item->AVAILABLE)) {
                    OrderSlipDetail::where('ORDERSLIPDETAILID', $item->ORDERSLIPDETAILID)
                        ->where('OSNUMBER', $item->OSNUMBER)
                        ->update([
                            'AVAILABLE' => (int)"$item->QUANTITY"
                        ]);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Successfully Confirmed',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'SERVER ERROR',
            ], 500);
        }
    }
}
