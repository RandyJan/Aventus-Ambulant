<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipHeader;
use App\Models\TableFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableCleanerController extends Controller
{
    public function update(){
        try{
            DB::beginTransaction();

            $items = TableFile::all();

            foreach ($items as $key => $item) {
                $os = OrderSlipHeader::where('OSNUMBER', $item->OSNUMBER)->first();

                if($os && $os->PAID == 1){
                    TableFile::where('BRANCH_ID', $item->BRANCH_ID)
                        ->where('TABLE_ID', $item->TABLE_ID)
                        ->where('TABLENO', $item->TABLENO)
                        ->update([
                            'OSNUMBER' => null
                        ]);
                }

                if(!$os){
                    TableFile::where('BRANCH_ID', $item->BRANCH_ID)
                        ->where('TABLE_ID', $item->TABLE_ID)
                        ->where('TABLENO', $item->TABLENO)
                        ->update([
                            'OSNUMBER' => null
                        ]);
                }
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
}
