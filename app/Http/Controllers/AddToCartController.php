<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipDetail;
use App\Models\OrderSlipHeader;
use App\Services\UpdateOrderslipTotalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddToCartController extends Controller
{
    protected $updateOrderslipTotalService;
    public function __construct()
    {
        $this->updateOrderslipTotalService = new UpdateOrderslipTotalService;
    }

    public function addToCart(Request $request)
    {
        try {
            DB::beginTransaction();

            $os = OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)->first();
            if (!$os) {
                DB::rollBack();
                return response()->json([
                    'message' => 'OS Not Found',
                ], 400);
            }

            if ($os->PAID == 1) {
                return response()->json([
                    'message' => 'This Transaction is already paid!, please create another transaction to continue.',
                ], 400);
            }
            // dd($request->all());

            $line_number = OrderSlipDetail::getNewLineNumber($os->OSNUMBER);
            $sequence = OrderSlipDetail::getNewProductSequence($os->OSNUMBER, $request->product['product_id']);

            OrderSlipDetail::create([
                'ORDERSLIPDETAILID' => OrderSlipDetail::getNewDetailId($os->OSNUMBER),
                'ORDERSLIPNO' => $os->ORDERSLIPNO,
                'BRANCHID' => $os->BRANCHID,
                'OUTLETID' => $os->OUTLETID,
                'DEVICENO' => $os->DEVICENO,
                'OSNUMBER' => $os->OSNUMBER,
                'PRODUCT_ID' => $request->product['product_id'],
                'RETAILPRICE' => $request->product['retail'],
                'QUANTITY' => $request->product['modified_quantity'],
                'REQUESTEDQTY' => config('settings.app_type') == 'shell_ambulant' ? $request->product['modified_quantity'] : null,
                'AMOUNT' => $request->product['amount'],
                'NETAMOUNT' => round($request->product['net_amount'], 2),
                'REMARKS' => $request->notes,
                'PARTNO' => $request->product['part_number'],
                'LINE_NO' => $line_number,
                'ORNO' => $line_number,
                'OSTYPE' => '2',
                'STATUS' => 'X',
                'SEQUENCE' => $sequence,
                'OSDATE' => getClarionDate(now()),
                'LOCATIONID' => $request->product['group'],
                'ENCODEDDATE' => now(),
                'DISPLAYMONITOR' => 1,
                'POSLINENO' => $line_number,
                'MAIN_PRODUCT_ID' => $request->product['product_id'],
                'OS_SC_ID' => $request->os_sc_id,
                'DISCID' => $request->product['discId'],

                'VATABLE_SALES' => round($request->product['vatable_sales'], 5),
                'VAT_AMOUNT' => round($request->product['vat_amount'], 5),
                'VAT_EX' => round($request->product['vat_ex'], 5),
                'SC_DISCOUNT_PERCENTAGE' => $request->product['sc_discount_percentage'],
                'SC_DISCOUNT_AMOUNT' => round($request->product['sc_discount_amount'], 5),
                'SC_COUNT' => $request->senior_headcount,
                // 'REG_COUNT' => $request->regular_headcount,
                'IS_GROUP_MEAL' => $request->product['is_group_meal'],
                'GROUP_SERVING' => $request->product['group_serving'],
                'PRODUCTGROUP' => $request->product['location'],
                'PSTATUS' => 0,
            ]);
            $line_number++;

            foreach ($request['non_modifiable'] as $key => $item) {
                # code...
                OrderSlipDetail::create([
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
                    'REQUESTEDQTY' => config('settings.app_type') == 'shell_ambulant' ? $item['modified_quantity'] : null,
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
                    'MAIN_PRODUCT_ID' => $request->product['product_id'],
                    'MAIN_PRODUCT_COMPONENT_ID' => $item['child_product_id'],
                    'PRODUCTGROUP' => $item['location'],
                    'OS_SC_ID' => $request->os_sc_id,
                    'DISCID' => $request->product['discId'],


                    'VATABLE_SALES' => 0,
                    'VAT_AMOUNT' => 0,
                    'SC_DISCOUNT_PERCENTAGE' => 0,
                    'SC_DISCOUNT_AMOUNT' => 0,
                    'PRODUCTGROUP' => $item['location'],
                    'PSTATUS' => 0,
                ]);
                $line_number++;
            }

            foreach ($request['modifiable'] as $key => $item) {
                # code...
                if ($item['modified_quantity'] > 0) {
                    OrderSlipDetail::create([
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
                        'REQUESTEDQTY' => config('settings.app_type') == 'shell_ambulant' ? $item['modified_quantity'] : null,
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
                        'MAIN_PRODUCT_ID' => $request->product['product_id'],
                        'MAIN_PRODUCT_COMPONENT_ID' => $item['child_product_id'],
                        'PRODUCTGROUP' => $item['location'],
                        'OS_SC_ID' => $request->os_sc_id,
                        'IS_MODIFY' => 1,
                        'POSTMIXID' => $request->product['product_id'],
                        'DISCID' => $request->product['discId'],



                        'VATABLE_SALES' => 0,
                        'VAT_AMOUNT' => 0,
                        'VAT_EX' => 0,
                        'SC_DISCOUNT_PERCENTAGE' => 0,
                        'SC_DISCOUNT_AMOUNT' => 0,
                        'PRODUCTGROUP' => $item['location'],
                        'PSTATUS' => 0,
                    ]);
                    $line_number++;
                }

                foreach ($item['group_products'] as $key => $sub_item) {
                    # code...
                    if ($sub_item['modified_quantity'] > 0) {
                        OrderSlipDetail::create([
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
                            'REQUESTEDQTY' => config('settings.app_type') == 'shell_ambulant' ? $sub_item['modified_quantity'] : null,
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
                            'MAIN_PRODUCT_ID' => $request->product['product_id'],
                            'MAIN_PRODUCT_COMPONENT_ID' => $item['child_product_id'],
                            'PRODUCTGROUP' => $sub_item['location'],
                            'OS_SC_ID' => $request->os_sc_id,
                            'IS_MODIFY' => 1,
                            'POSTMIXID' => $request->product['product_id'],
                            'DISCID' => $request->product['discId'],

                            'VATABLE_SALES' => round($sub_item['vatable_sales'], 5),
                            'VAT_AMOUNT' => round($sub_item['vat_amount'], 5),
                            'VAT_EX' => round($sub_item['vat_ex'], 5),
                            'SC_DISCOUNT_PERCENTAGE' => round($sub_item['sc_discount_percentage'], 5),
                            'SC_DISCOUNT_AMOUNT' => round($sub_item['sc_discount_amount'], 5),
                            'PRODUCTGROUP' => $sub_item['location'],
                            'PSTATUS' => 0,
                        ]);
                        $line_number++;
                    }
                }
            }

            $this->updateOrderslipTotalService->handle($request->orderslip_number);

            DB::commit();
            return response()->json([
                'message' => 'Update Successfully',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
