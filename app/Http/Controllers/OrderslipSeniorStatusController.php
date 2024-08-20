<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipHeader;
use App\Models\OrderslipSenior;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderslipSeniorStatusController extends Controller
{
    public function update(Request $request){
        // dd($request->all());
        try{
            DB::beginTransaction();

            OrderSlipHeader::where('OSNUMBER', $request->os_number)
                ->update([
                    'IS_SC' => $request->sc_status
                ]);

            if($request->sc_status == 0){
                OrderslipSenior::where('OSNUMBER', $request->os_number)
                ->where('BRANCH_ID', $request->branch_id)
                ->delete();
            }

            DB::commit();
            return response()->json([
                'message' => 'Ok',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'system_message' => $e->getMessage()
            ], 500);
        }
    }
}
