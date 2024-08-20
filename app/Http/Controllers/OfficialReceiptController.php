<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfficialReceipt as ResourcesOfficialReceipt;
use App\Http\Resources\OfficialReceiptCollection;
use App\Models\OfficialReceipt;
use App\Services\RemoveCurrentTransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfficialReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $items = OfficialReceipt::orderBy('GLHID', 'desc')
                ->when($request->filter_by_today, function($q){
                    $q->whereDate('DATE', now()->format('Y-m-d'));
                })
                ->paginate($request->limit);

            return new OfficialReceiptCollection($items);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'SERVER ERROR',
                'system' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $or = new OfficialReceipt;

            $generated_id = $or->getNewID();
            $item = OfficialReceipt::create([
                'GLHID' => $generated_id,
                'GLTYPE' => 'R',
                'BRANCHCODE' => 1,
                'DATE' => now(),
                'REFDATE' => getClarionDate(now()),
                'REFNUM' => $generated_id,
                'POSNO' => $request->device_id,
                'empno' => Auth::user()->NUMBER,
                'COLLECTORID' => Auth::user()->ID,
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Ok',
                'data' => new ResourcesOfficialReceipt($item)
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
        try {

            $or = OfficialReceipt::where('GLHID', $id)->first();

            if (!$or) {
                return response()->json([
                    'message' => 'Not Found'
                ], 404);
            }

            return response()->json([
                'message' => 'ok',
                'data' => [
                    'header' => new ResourcesOfficialReceipt($or),
                    'payments' => [],
                    'invoices' => [],
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'SERVER ERROR',
                'system' => $e->getMessage()
            ], 500);
        }
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
        //
    }
}
