<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdjustmentRate as adjr;
class LookUpController extends Controller
{
    //
    public function getDiscount(){
        $result = adjr::where('ACTIVE',1)->get();

        return response()->json($result,200);
    }
}
