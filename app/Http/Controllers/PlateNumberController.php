<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipHeader;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlateNumberController extends Controller
{
    public function update(Request $request){
        try{
            DB::beginTransaction();

            OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)
                ->update([
                    'QUEUEDNAME' => $request->plate_number
                ]);

            DB::commit();
            return response()->json([
                'message' => 'Ok',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
