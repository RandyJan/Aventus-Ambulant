<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class OrderslipSendToEmailController extends Controller
{
    public function store(Request $request, $orderslip_code){

        Artisan::call("ambulant:invoice", [
            'orderslip_number' => $orderslip_code
        ]);

        return response()->json([
            'message' => 'Email has been sent.'
        ]);
    }
}
