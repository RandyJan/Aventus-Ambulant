<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipDetail;
use App\Models\OrderSlipHeader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function editItemOnCart(Request $request){
        try{
            DB::beginTransaction();

            $os = OrderSlipHeader::where('OSNUMBER', $request->os_number)->first();
            if(!$os){
                DB::rollBack();
                return response()->json([
                    'message' => 'OS Not Found',
                ], 400);
            }

            if($os->PAID == 1){
                return response()->json([
                    'message' => 'This Transaction is already paid!, please create another transaction to continue.',
                ], 400);
            }

            OrderSlipDetail::where('ORDERSLIPDETAILID', $request->orderslip_detail_id)
                ->where('BRANCHID', $request->branch_id)
                ->where('OUTLETID', $request->outlet_id)
                ->where('DEVICENO', $request->device_id)
                ->where('PRODUCT_ID', $request->product_id)
                ->update([
                    'QUANTITY' => $request->quantity,
                    'AMOUNT' => $request->amount,
                    'NETAMOUNT' => $request->amount,
                    'REMARKS' => $request->remarks,
                ]);


            // UPDATE THE TOTALs
            $items = OrderSlipDetail::where('OSNUMBER', $os->OSNUMBER)
                ->get();

            OrderSlipHeader::where('OSNUMBER', $os->OSNUMBER)
                ->update([
                    'TOTALAMOUNT' => $items->sum('AMOUNT'),
                    'NETAMOUNT' => $items->sum('NETAMOUNT'),
                ]);

            DB::commit();
            return response()->json([
                'message' => 'Successfully Saved!',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function removeItemOnCart(Request $request){
        try{
            DB::beginTransaction();

            $os = OrderSlipHeader::where('OSNUMBER', $request->os_number)->first();
            if(!$os){
                DB::rollBack();
                return response()->json([
                    'message' => 'OS Not Found',
                ], 400);
            }

            if($os->PAID == 1){
                return response()->json([
                    'message' => 'This Transaction is already paid!, please create another transaction to continue.',
                ], 400);
            }

            OrderSlipDetail::where('ORDERSLIPDETAILID', $request->orderslip_detail_id)
                ->where('BRANCHID', $request->branch_id)
                ->where('OUTLETID', $request->outlet_id)
                ->where('DEVICENO', $request->device_id)
                ->where('PRODUCT_ID', $request->product_id)
                ->delete();


            // UPDATE THE TOTALs
            $items = OrderSlipDetail::where('OSNUMBER', $os->OSNUMBER)
                ->get();

            OrderSlipHeader::where('OSNUMBER', $os->OSNUMBER)
                ->update([
                    'TOTALAMOUNT' => $items->sum('AMOUNT'),
                    'NETAMOUNT' => $items->sum('NETAMOUNT'),
                ]);

            DB::commit();
            return response()->json([
                'message' => 'Removed Successfully!',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function customerDisplay(Request $request){
        try{
            DB::beginTransaction();

            // if there is on. make it off
            OrderSlipHeader::where('DEVICENO', $request->device_id)
                ->where('BRANCHID', $request->branch_id)
                ->where('CUSTOMERDISPLAY', 1)
                ->update([
                    'CUSTOMERDISPLAY' => 0
                ]);
            // end

            OrderSlipHeader::where('OSNUMBER', $request->os_number)
                ->where('BRANCHID', $request->branch_id)
                ->update([
                    'CUSTOMERDISPLAY' => $request->customer_display
                ]);

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
