<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipHeader;
use App\Models\OrderslipTable;
use App\Models\TableFile;
use App\Services\UpdateTheTableInOrderslip;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderslipTableController extends Controller
{
    protected $updateTheTableInOrderslipService;

    public function __construct()
    {
       $this->updateTheTableInOrderslipService = new UpdateTheTableInOrderslip;
    }

    public function store(Request $request){

        try{
            DB::beginTransaction();

            OrderslipTable::create([
                'BRANCHID' => $request->branch_id,
                'OUTLETID' => $request->outlet_id,
                'DEVICENO' => $request->device_id,
                'ORDERLIPNO' => $request->orderslip_id,
                'TABLENO' => $request->table_id,
                'CREATED' => now(),
            ]);

            TableFile::where('BRANCH_ID', $request->branch_id)
                ->where('TABLE_ID', $request->table_id)
                ->update([
                    'OSNUMBER' => $request->osnumber
                ]);

            $result = $this->updateTheTableInOrderslipService->handle($request->osnumber);
            if(!$result['success']){
                DB::rollBack();
                Log::error($result['message']);
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], Response::HTTP_BAD_REQUEST);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Table has been added.',
            ], Response::HTTP_CREATED);

        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'SERVER ERROR',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request){
        try{
            DB::beginTransaction();

            OrderslipTable::where([
                'BRANCHID' => $request->branch_id,
                'OUTLETID' => $request->outlet_id,
                'DEVICENO' => $request->device_id,
                'ORDERLIPNO' => $request->orderslip_id,
                'TABLENO' => $request->table_id,
            ])->delete();

            TableFile::where('BRANCH_ID', $request->branch_id)
                ->where('TABLE_ID', $request->table_id)
                ->update([
                    'OSNUMBER' => null
                ]);

            $os = OrderSlipHeader::
                where('BRANCHID', $request->branch_id)
                ->where('OUTLETID', $request->outlet_id)
                ->where('DEVICENO', $request->device_id)
                ->where('ORDERSLIPNO', $request->orderslip_id)
                ->first();

            $result = $this->updateTheTableInOrderslipService->handle($os->OSNUMBER);
            if(!$result['success']){
                DB::rollBack();
                Log::error($result['message']);
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], Response::HTTP_BAD_REQUEST);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Table has been remove',
            ], Response::HTTP_CREATED);

        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'SERVER ERROR',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
