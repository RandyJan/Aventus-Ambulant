<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipHeader;
use Illuminate\Http\Request;

class OrderslipCustomerController extends Controller
{
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
     * @param  string  $orderslip_code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orderslip_code)
    {
        OrderSlipHeader::where('OSNUMBER', $orderslip_code)
            ->update([
                'CUSTOMERCODE' => $request->customer_code
            ]);

        return response()->json([
            'message' => 'Successfully updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $orderslip_code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $orderslip_code)
    {
        OrderSlipHeader::where('OSNUMBER', $orderslip_code)
            ->update([
                'CUSTOMERCODE' => null
            ]);

        return response()->json([
            'message' => 'Successfully removed.'
        ]);
    }
}
