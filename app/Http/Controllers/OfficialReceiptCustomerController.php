<?php

namespace App\Http\Controllers;

use App\Models\OfficialReceipt;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficialReceiptCustomerController extends Controller
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
    public function store(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $or = OfficialReceipt::where('GLHID', $id)->first();

            if (!$or) {
                return response()->json([
                    'message' => 'Not Found'
                ], 404);
            }


            OfficialReceipt::where('GLHID', $id)
                ->update([
                    'SUPPCODE' => $request->account_code,
                    'PAYEE' => $request->account_name,
                ]);

            DB::commit();
            return response()->json([
                'message' => 'ok',
                'data' => [
                ],
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'system' => $e->getMessage()
            ], 500);
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $or = OfficialReceipt::where('GLHID', $id)->first();

            if (!$or) {
                return response()->json([
                    'message' => 'Not Found'
                ], 404);
            }


            OfficialReceipt::where('GLHID', $id)
                ->update([
                    'SUPPCODE' => null,
                    'PAYEE' => null,
                ]);

            DB::commit();
            return response()->json([
                'message' => 'ok',
                'data' => [
                ],
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
