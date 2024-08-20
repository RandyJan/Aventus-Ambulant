<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipHeader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TotalHeadCountController extends Controller
{
    public function update(Request $request){
        try{
            DB::beginTransaction();

            OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)
                ->update([
                    'TOTALHEADCOUNT' => $request->value
                ]);

            DB::commit();
            return response()->json([
                'message' => 'Ok',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'SERVER ERROR',
                'system_message' => $e->getMessage()
            ], 500);
        }
    }
}
