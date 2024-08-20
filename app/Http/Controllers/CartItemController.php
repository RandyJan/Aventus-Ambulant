<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipDetail;
use App\Models\OrderSlipHeader;
use App\Models\User;
use App\Services\UpdateOrderslipTotalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    protected $updateOrderslipTotalService;
    public function __construct()
    {
        $this->updateOrderslipTotalService = new UpdateOrderslipTotalService;
    }

    public function update(Request $request){
        // dd(
        //     $request->parent,
        //     $request->non_modifiable,
        //     $request->modifiable,
        //     $request['non_modifiable'],
        //     $request->all()
        // );
        try{
            DB::beginTransaction();


            if(config('settings.app_type') == 'restaurant_ambulant'){

                $user = User::where('NUMBER', $request->supervisor['username'])
                    ->where('PW', $request->supervisor['password'])
                    ->first();

                if(!$user){
                    DB::rollBack();
                    return response()->json([
                        'message' => 'User not found!'
                    ], Response::HTTP_NOT_FOUND);
                }

                if($user->can_void != 1 || $user->can_void != '1'){
                    DB::rollBack();
                    return response()->json([
                        'message' => 'User does not have ability to void!'
                    ], Response::HTTP_NOT_FOUND);
                }
            }


            $os = OrderSlipHeader::where('OSNUMBER', $request->os_number)->first();
            if(!$os){
                DB::rollBack();
                return response()->json([
                    'message' => 'OS Not Found',
                ], Response::HTTP_NOT_FOUND);
            }


            if($os->PAID == 1){
                return response()->json([
                    'message' => 'This Transaction is already paid!, please create another transaction to continue.',
                ], Response::HTTP_BAD_REQUEST);
            }

            // get the data needs to remain
            $parentItem = OrderSlipDetail::where('OSNUMBER', $request->os_number)
                ->where('MAIN_PRODUCT_ID', $request->parent['product_id'])
                ->where('SEQUENCE', $request->parent['sequence'])
                ->first();


            // remove first the item
            OrderSlipDetail::where('OSNUMBER', $request->os_number)
                ->where('MAIN_PRODUCT_ID', $request->parent['product_id'])
                ->where('SEQUENCE', $request->parent['sequence'])
                ->delete();

            $line_number = OrderSlipDetail::getNewLineNumber($os->OSNUMBER);
            $sequence = $request->parent['sequence'];

            $payload = [
                'ORDERSLIPDETAILID' => OrderSlipDetail::getNewDetailId($os->OSNUMBER),
                'ORDERSLIPNO' => $os->ORDERSLIPNO,
                'BRANCHID' => $os->BRANCHID,
                'OUTLETID' => $os->OUTLETID,
                'DEVICENO' => $os->DEVICENO,
                'OSNUMBER' => $os->OSNUMBER,
                'MAIN_OSNUMBER' => $os->OSNUMBER,
                'PRODUCT_ID' => $request->parent['product_id'],
                'RETAILPRICE' => $request->parent['price'],
                'QUANTITY' => $request->parent['modified_quantity'],
                'REQUESTEDQTY' => $request->parent['modified_quantity'],
                'AMOUNT' => $request->parent['amount'],
                'NETAMOUNT' => round($request->parent['net_amount'], 2),
                'REMARKS' => $request->parent['remarks'],
                'PARTNO' => $request->parent['part_number'],
                'LINE_NO' => $line_number,
                'ORNO' => $line_number,
                'OSTYPE' => '2',
                'STATUS' => 'X',
                'SEQUENCE' => $sequence,
                'OSDATE' => getClarionDate(now()),
                'LOCATIONID' => $request->parent['group'],
                'ENCODEDDATE' => now(),
                'DISPLAYMONITOR' => 1,
                'POSLINENO' => $line_number,
                'MAIN_PRODUCT_ID' => $request->parent['product_id'],
                'PRODUCTGROUP' => $request->parent['location'],
                'OS_SC_ID' => $request->os_sc_id,

                'VATABLE_SALES' => round($request->parent['vatable_sales'], 5),
                'VAT_AMOUNT' => round($request->parent['vat_amount'], 5),
                'VAT_EX' => round($request->parent['vat_ex'], 5),
                'SC_DISCOUNT_PERCENTAGE' => $request->parent['sc_discount_percentage'],
                'SC_DISCOUNT_AMOUNT' => round($request->parent['sc_discount_amount'], 5),
                'SC_COUNT' => $request->senior_headcount,
                // 'REG_COUNT' => $request->regular_headcount,
                'IS_GROUP_MEAL' => $request->parent['is_group_meal'],
                'GROUP_SERVING' => $request->parent['group_serving'],
                'PRODUCTGROUP' => $request->parent['location'],

                // 'CONFIRMED_AT' => $parentItem->CONFIRMED_AT,
                // 'PSTATUS' => $parentItem->PSTATUS,
            ];

            if(config('settings.app_type') == 'restaurant_ordering'){
                $payload['CONFIRMED_AT'] = $parentItem->CONFIRMED_AT;
                $payload['PSTATUS'] = $parentItem->PSTATUS;
            }

            OrderSlipDetail::create($payload);
            $line_number++;


            foreach ($request['non_modifiable'] as $key => $item) {
                # code...
                $payload = [
                    'ORDERSLIPDETAILID' => OrderSlipDetail::getNewDetailId($os->OSNUMBER),
                    'ORDERSLIPNO' => $os->ORDERSLIPNO,
                    'BRANCHID' => $os->BRANCHID,
                    'OUTLETID' => $os->OUTLETID,
                    'DEVICENO' => $os->DEVICENO,
                    'OSNUMBER' => $os->OSNUMBER,
                    'MAIN_OSNUMBER' => $os->OSNUMBER,
                    'PRODUCT_ID' => $item['child_product_id'],
                    'PARTNO' => $item['child_part_no'],
                    'RETAILPRICE' => $item['child_unit_cost'],
                    'QUANTITY' => $item['modified_quantity'],
                    'REQUESTEDQTY' => $item['modified_quantity'],
                    'AMOUNT' => 0,
                    'NETAMOUNT' => 0,
                    // 'REMARKS' => $request->notes,
                    'LINE_NO' => $line_number,
                    'ORNO' => $line_number,
                    'OSTYPE' => '2',
                    'STATUS' => 'X',
                    'SEQUENCE' => $sequence,
                    'OSDATE' => getClarionDate(now()),
                    'LOCATIONID' => $item['group_code'],
                    'ENCODEDDATE' => now(),
                    'DISPLAYMONITOR' => 1,
                    'POSLINENO' => $line_number,
                    'MAIN_PRODUCT_ID' => $request->parent['product_id'],
                    'MAIN_PRODUCT_COMPONENT_ID' => $item['child_product_id'],
                    'PRODUCTGROUP' => $item['location'],
                    'OS_SC_ID' => $request->os_sc_id,

                    'VATABLE_SALES' => 0,
                    'VAT_AMOUNT' => 0,
                    'SC_DISCOUNT_PERCENTAGE' => 0,
                    'SC_DISCOUNT_AMOUNT' => 0,
                    'PRODUCTGROUP' => $item['location'],

                    // 'CONFIRMED_AT' => $parentItem->CONFIRMED_AT,
                    // 'PSTATUS' => $parentItem->PSTATUS,
                ];

                if(config('settings.app_type') == 'restaurant_ordering'){
                    $payload['CONFIRMED_AT'] = $parentItem->CONFIRMED_AT;
                    $payload['PSTATUS'] = $parentItem->PSTATUS;
                }

                OrderSlipDetail::create($payload);
                $line_number++;
            }

            foreach ($request['modifiable'] as $key => $item) {
                # code...
                if($item['modified_quantity'] > 0){
                    $payload = [
                        'ORDERSLIPDETAILID' => OrderSlipDetail::getNewDetailId($os->OSNUMBER),
                        'ORDERSLIPNO' => $os->ORDERSLIPNO,
                        'BRANCHID' => $os->BRANCHID,
                        'OUTLETID' => $os->OUTLETID,
                        'DEVICENO' => $os->DEVICENO,
                        'OSNUMBER' => $os->OSNUMBER,
                        'MAIN_OSNUMBER' => $os->OSNUMBER,
                        'PRODUCT_ID' => $item['child_product_id'],
                        'PARTNO' => $item['child_part_no'],
                        'RETAILPRICE' => $item['child_unit_cost'],
                        'QUANTITY' => $item['modified_quantity'],
                        'REQUESTEDQTY' => $item['modified_quantity'],
                        'AMOUNT' => 0,
                        'NETAMOUNT' => 0,
                        // 'REMARKS' => $request->notes,
                        'LINE_NO' => $line_number,
                        'ORNO' => $line_number,
                        'OSTYPE' => '2',
                        'STATUS' => 'X',
                        'SEQUENCE' => $sequence,
                        'OSDATE' => getClarionDate(now()),
                        'LOCATIONID' => $item['group_code'],
                        'ENCODEDDATE' => now(),
                        'DISPLAYMONITOR' => 1,
                        'POSLINENO' => $line_number,
                        'MAIN_PRODUCT_ID' => $request->parent['product_id'],
                        'MAIN_PRODUCT_COMPONENT_ID' => $item['child_product_id'],
                        'PRODUCTGROUP' => $item['location'],
                        'OS_SC_ID' => $request->os_sc_id,
                        'IS_MODIFY' => 1,
                        'POSTMIXID' => $request->parent['product_id'],

                        'VATABLE_SALES' => 0,
                        'VAT_AMOUNT' => 0,
                        'VAT_EX' => 0,
                        'SC_DISCOUNT_PERCENTAGE' => 0,
                        'SC_DISCOUNT_AMOUNT' => 0,
                        'PRODUCTGROUP' => $item['location'],

                        // 'CONFIRMED_AT' => $parentItem->CONFIRMED_AT,
                        // 'PSTATUS' => $parentItem->PSTATUS,
                    ];

                    if(config('settings.app_type') == 'restaurant_ordering'){
                        $payload['CONFIRMED_AT'] = $parentItem->CONFIRMED_AT;
                        $payload['PSTATUS'] = $parentItem->PSTATUS;
                    }

                    OrderSlipDetail::create($payload);
                    $line_number++;
                }

                foreach ($item['group_products'] as $key => $sub_item) {
                    # code...
                    if($sub_item['modified_quantity'] > 0){
                        $payload = [
                            'ORDERSLIPDETAILID' => OrderSlipDetail::getNewDetailId($os->OSNUMBER),
                            'ORDERSLIPNO' => $os->ORDERSLIPNO,
                            'BRANCHID' => $os->BRANCHID,
                            'OUTLETID' => $os->OUTLETID,
                            'DEVICENO' => $os->DEVICENO,
                            'OSNUMBER' => $os->OSNUMBER,
                            'MAIN_OSNUMBER' => $os->OSNUMBER,
                            'PRODUCT_ID' => $sub_item['product_id'],
                            'PARTNO' => $sub_item['part_number'],
                            'RETAILPRICE' => $sub_item['retail_price'],
                            'QUANTITY' => $sub_item['modified_quantity'],
                            'REQUESTEDQTY' => $sub_item['modified_quantity'],
                            'AMOUNT' => $sub_item['amount'],
                            'NETAMOUNT' => round($sub_item['net_amount'], 2),
                            // 'REMARKS' => $request->notes,
                            'LINE_NO' => $line_number,
                            'ORNO' => $line_number,
                            'OSTYPE' => '2',
                            'STATUS' => 'X',
                            'SEQUENCE' => $sequence,
                            'OSDATE' => getClarionDate(now()),
                            'LOCATIONID' => $sub_item['group'],
                            'ENCODEDDATE' => now(),
                            'DISPLAYMONITOR' => 1,
                            'POSLINENO' => $line_number,
                            'MAIN_PRODUCT_ID' => $request->parent['product_id'],
                            'MAIN_PRODUCT_COMPONENT_ID' => $item['child_product_id'],
                            'PRODUCTGROUP' => $sub_item['location'],
                            'OS_SC_ID' => $request->os_sc_id,
                            'IS_MODIFY' => 1,
                            'POSTMIXID' => $request->parent['product_id'],

                            'VATABLE_SALES' => round($sub_item['vatable_sales'], 5),
                            'VAT_AMOUNT' => round($sub_item['vat_amount'], 5),
                            'VAT_EX' => round($sub_item['vat_ex'], 5),
                            'SC_DISCOUNT_PERCENTAGE' => round($sub_item['sc_discount_percentage'], 5),
                            'SC_DISCOUNT_AMOUNT' => round($sub_item['sc_discount_amount'], 5),
                            'PRODUCTGROUP' => $sub_item['location'],

                            // 'CONFIRMED_AT' => $parentItem->CONFIRMED_AT,
                            // 'PSTATUS' => $parentItem->PSTATUS,
                        ];

                        if(config('settings.app_type') == 'restaurant_ordering'){
                            $payload['CONFIRMED_AT'] = $parentItem->CONFIRMED_AT;
                            $payload['PSTATUS'] = $parentItem->PSTATUS;
                        }

                        OrderSlipDetail::create($payload);
                        $line_number++;
                    }
                }
            }

            $this->updateOrderslipTotalService->handle( $request->os_number );

            DB::commit();
            return response()->json([
                'message' => 'Successfully Saved!',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'system_message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request){
        try{
            DB::beginTransaction();

            if(config('settings.app_type') == 'restaurant_ambulant'){

                $user = User::where('NUMBER', $request->supervisor['username'])
                    ->where('PW', $request->supervisor['password'])
                    ->first();

                if(!$user){
                    DB::rollBack();
                    return response()->json([
                        'message' => 'User not found!'
                    ], Response::HTTP_NOT_FOUND);
                }

                if($user->can_void != 1 || $user->can_void != '1'){
                    DB::rollBack();
                    return response()->json([
                        'message' => 'User does not have ability to void!'
                    ], Response::HTTP_NOT_FOUND);
                }
            }

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

            OrderSlipDetail::where('OSNUMBER', $request->os_number)
                ->where('MAIN_PRODUCT_ID', $request->product_id)
                ->where('SEQUENCE', $request->sequence)
                ->delete();

            $this->updateOrderslipTotalService->handle( $request->os_number );

            DB::commit();
            return response()->json([
                'message' => 'Removed Successfully!',
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
