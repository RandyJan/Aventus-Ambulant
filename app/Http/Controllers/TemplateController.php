<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    public function your_method(Request $request){
        // dd($request->all());
        try{
            DB::beginTransaction();

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
