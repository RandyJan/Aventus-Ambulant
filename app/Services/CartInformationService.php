<?php

namespace App\Services;

use App\Http\Resources\BranchCustomer;
use App\Http\Resources\Group as ResourcesGroup;
use App\Http\Resources\OrderSlipDetails;
use App\Http\Resources\OrderSlipDetailsCollection;
use App\Http\Resources\OrderslipSenior as ResourcesOrderslipSenior;
use App\Http\Resources\OrderslipTable as ResourcesOrderslipTable;
use App\Models\Customer;
use App\Models\Group;
use App\Models\OrderSlipDetail;
use App\Models\OrderSlipHeader;
use App\Models\OrderslipSenior;
use App\Models\OrderslipTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartInformationService
{

    /**
     * @param String $orderslip_number
     * @return array
     */
    public function handle(
        $orderslip_number
    ): array {
        try {
            DB::beginTransaction();

            $os = OrderSlipHeader::where('OSNUMBER', $orderslip_number)->first();

            if (!$os) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Resource not found',
                ];
            }

            $status = '';

            if ($os->PAID == 0) {
                $status = 'Pending';
            }

            if ($os->PAID == 1) {
                $status = 'Paid';
                if ($os->QDATE != null) {
                    $status = 'Completed';
                }
            }

            $data = [
                'orderslip_id'      => $os->ORDERSLIPNO,
                'orderslip_number'  => $os->OSNUMBER,
                'prepared_by'       => trim($os->PREPAREDBY),
                'date'              => Carbon::parse($os->ENCODEDDATE)->format('Y-m-d'),
                'time'              => Carbon::parse($os->ENCODEDDATE)->format('h:i:s a'),
                'plate_number'      => trim($os->QUEUEDNAME),
                'table_number'      => '',
                'tables'            => [],
                'stores'            => [],
                // 'total_amount'      => number_format($os->TOTALAMOUNT, 2),
                'total_amount'      => number_format($os->TOTALAMOUNT, 2),
                'net_amount'        => number_format($os->NETAMOUNT, 2),
                'status'            => $status,
                'duration'          => computeDuration(Carbon::parse($os->OSDATE), $os->QDATE),
                'is_sc'             => $os->IS_SC == 1 ? true : false,
                'sc_records'        => [],
                'total_headcount'   => $os->TOTALHEADCOUNT ? $os->TOTALHEADCOUNT : 0,
                'customer_display'  => $os->CUSTOMERDISPLAY == 1 ? true : false,

                'vatable_sales'     => number_format($os->VATABLE_SALES, 2),
                'vat_amount'        => number_format($os->VAT_AMOUNT, 2),
                'vat_ex'            => number_format($os->VAT_EX, 2),
                'sc_discount_percentage'    => number_format($os->SC_DISCOUNT_PERCENTAGE, 2),
                'sc_discount_amount'        => number_format($os->SC_DISCOUNT_AMOUNT, 2),
                'customer'=>null,
                'customer_name' => $os->CUSTOMERNAME,
                'order_type'            => trim($os->OSTYPE),
                'service_charge_percentage' => $os->SERVICE_CHARGE_PERCENTAGE,
                'service_charge_amount' => number_format($os->SERVICE_CHARGE_AMT, 2)
            ];

            $osd = OrderSlipDetail::with(['product'])
                ->where('BRANCHID', $os->BRANCHID)
                ->where('OUTLETID', $os->OUTLETID)
                ->where('DEVICENO', $os->DEVICENO)
                ->where('ORDERSLIPNO', $os->ORDERSLIPNO)
                ->where('STATUS', '!=', 'V')
                ->get();

            // GET STORES
            foreach ($osd->unique('LOCATIONID')->pluck('LOCATIONID')->toArray() as $key => $store_code) {
                # code...

                $store = Group::where('GROUPCODE', $store_code)
                    ->when(config('settings.app_type') == 'shell_ambulant', function ($q) {
                        $q->where('BSUNITCODE', config('settings.stores'));
                    })
                    ->first();
                $store_data['store'] = new ResourcesGroup($store);

                // dd('.');

                // GET ORDERS OF THE STORE
                // $store_data['store_orders'] = new OrderSlipDetailsCollection($osd->where('LOCATIONID', $store_code));
                // Log::debug('store osd count', [
                //     $osd->where('LOCATIONID', $store_code)->count()
                // ]);
                $store_data['store_orders'] = $this->itemsGrouper(
                    $osd->where('LOCATIONID', $store_code)
                );

                // GET THE SUB TOTAL AMOUNT OF THE STORE
                $store_data['sub_total'] = number_format(
                    $osd->where('LOCATIONID', $store_code)
                        ->sum('NETAMOUNT'),
                    // ->sum('AMOUNT'),
                    2
                );

                array_push($data['stores'], $store_data);
            }

            $data['items_count'] = $osd->filter(function ($v, $k) {
                return $v->PRODUCT_ID == $v->MAIN_PRODUCT_ID;
            })->count();

            $data['unconfirmed_items'] = $osd->filter(function ($v, $k) {
                return $v->PRODUCT_ID == $v->MAIN_PRODUCT_ID && $v->CONFIRMED_AT == null;
            })->count();

            // TABLE
            if (config('settings.table_assignment')) {
                $tables = OrderslipTable::with(['table' => function ($q) use ($os) {
                    $q->where('BRANCH_ID', $os->BRANCHID);
                }])
                    ->where('BRANCHID', $os->BRANCHID)
                    ->where('OUTLETID', $os->OUTLETID)
                    ->where('DEVICENO', $os->DEVICENO)
                    ->where('ORDERLIPNO', $os->ORDERSLIPNO)
                    ->get();

                $data['tables'] = ResourcesOrderslipTable::collection($tables);
                $data['table_number'] = implode(
                    ', ',
                    $tables->pluck('table.TABLECODE')->map(function ($data) {
                        return trim($data);
                    })->toArray()
                );
            }
            // END TABLE


            if ($data['is_sc']) {
                $seniors = OrderslipSenior::where('OSNUMBER', $os->OSNUMBER)->get();
                $data['sc_records'] = ResourcesOrderslipSenior::collection($seniors);
            }

            // adding customer payload
            if (!empty($os->CUSTOMERCODE)) {
                $customer = Customer::where('CUSTOMERCODE', $os->CUSTOMERCODE)
                    // ->where('BRANCHORIGIN', $os->BRANCHID)
                    ->active()
                    ->first();

                // Log::debug('CUSTOMER', [$customer]);

                if ($customer) {
                    $data['customer']  = $customer;
                    $data['formatted_customer'] = new BranchCustomer($customer);
                }
            }
            //

            DB::commit();
            return [
                'success' => true,
                'message' => 'Ok',
                'data' => $data
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    protected function itemsGrouper(Collection $collections)
    {

        $filtered_items = $collections->filter(function ($v, $k) {
            return $v->PRODUCT_ID == $v->MAIN_PRODUCT_ID;
        })
            ->values()
            ->sortBy('product.DESCRIPTION')
            ->values();

        // Log::debug('...', [$filtered_items]);

        $data = [];
        foreach ($filtered_items as $key => $main_product) {

            $item_data['parent'] = OrderSlipDetails::make($main_product);
            $item_data['items'] = new OrderslipDetailsCollection(
                $collections->where('MAIN_PRODUCT_ID', $main_product->PRODUCT_ID)
                    ->where('PRODUCT_ID', '!=', $main_product->PRODUCT_ID)
                    ->where('SEQUENCE', $main_product->SEQUENCE)
                    ->values()
            );
            $item_data['sub_total'] = number_format(
                $collections->where('MAIN_PRODUCT_ID', $main_product->PRODUCT_ID)
                    ->where('SEQUENCE', $main_product->SEQUENCE)
                    ->sum('NETAMOUNT'),
                2
            );

            array_push($data, $item_data);
        }


        return $data;
    }
}
