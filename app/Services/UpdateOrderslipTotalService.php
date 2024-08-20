<?php

namespace App\Services;

use App\Models\OrderSlipDetail;
use App\Models\OrderSlipHeader;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateOrderslipTotalService
{

    /**
     * @param String $os_number
     * @return array
     */
    public function handle(
        $os_number,
        $order_type = null
    ): array {
        try {
            DB::beginTransaction();

            // Log::debug('os_number: ' . $os_number);

            $os = OrderSlipHeader::where('OSNUMBER', $os_number)->first();
            $all_items = OrderSlipDetail::where('OSNUMBER', $os_number)->get();

            $os_payload = [
                'TOTALAMOUNT' => 0,
                'NETAMOUNT' => 0,
                'VATABLE_SALES' => 0,
                'VAT_AMOUNT' => 0,
                'VAT_EX' => 0,
                'SC_DISCOUNT_PERCENTAGE' => 0,
                'SC_DISCOUNT_AMOUNT' => 0,
            ];
            if (config('settings.app_type') == 'restaurant_ambulant') {
                $os_payload['SERVICE_CHARGE_AMT'] = 0;
            }
            OrderSlipHeader::where('OSNUMBER', $os_number)
                ->update($os_payload);

            // Log::debug('$all_items', $all_items->toArray());
            foreach ($all_items->groupBy('OSNUMBER') as $key => $items_per_os) {
                # code...

                $payload = [
                    
                    'TOTALAMOUNT' => $items_per_os->sum('AMOUNT'),
                    'VATABLE_SALES' => $items_per_os->sum('VATABLE_SALES'),
                    'VAT_AMOUNT' => $items_per_os->sum('VAT_AMOUNT'),
                    // 'VAT_EX_WITHOUT_SERVICE_CHARGE' => $items_per_os->sum('VAT_EX'),
                    'VAT_EX' => $items_per_os->sum('VAT_EX'),
                    'SC_DISCOUNT_PERCENTAGE' => $items_per_os->sum('SC_DISCOUNT_PERCENTAGE'),
                    'SC_DISCOUNT_AMOUNT' => $items_per_os->sum('SC_DISCOUNT_AMOUNT'),
                    // 'SERVICE_CHARGE_AMT' => 0,
                    'NETAMOUNT' => $items_per_os->sum('NETAMOUNT'),
                ];

                // $payload['NETAMOUNT'] =
                //     $payload['VATABLE_SALES'] + $payload['VAT_AMOUNT'] +
                //     $payload['VAT_EX']
                //     - $payload['SC_DISCOUNT_AMOUNT'];

                if (trim($os->OSTYPE) == '1' && config('settings.service_charge') == true) {
                    // $SERVICE_CHARGE_AMT = ($payload['TOTALAMOUNT'] / 1.12) * .12;
                    // $SERVICE_CHARGE_AMT = $payload['TOTALAMOUNT'] - $SERVICE_CHARGE_AMT;
                    $SERVICE_CHARGE_AMT = $payload['TOTALAMOUNT'];
                    $SERVICE_CHARGE_AMT = $SERVICE_CHARGE_AMT * ($os->SERVICE_CHARGE_PERCENTAGE / 100);
                    // $SERVICE_CHARGE_AMT = round($SERVICE_CHARGE_AMT, 2);
                    $vatex = ($payload['TOTALAMOUNT']/1.12) + $SERVICE_CHARGE_AMT;
                    $payload['SERVICE_CHARGE_AMT'] = $SERVICE_CHARGE_AMT;   
                    $payload['VAT_EX'] = $vatex;
                    $payload['NETAMOUNT'] = $payload['NETAMOUNT'] + $SERVICE_CHARGE_AMT;
                }

                // logger('totals ostype:' . $os->OSTYPE, [
                //     'key' => $key,
                //     'net' => $payload['NETAMOUNT'],
                //     'new' => $payload,
                //     // 'old' => $old_payload
                // ]);
                // logger('payload', $payload);

                OrderSlipHeader::where('OSNUMBER', $key)
                    ->update($payload);
            }

            DB::commit();
            return [
                'success' => true,
                'message' => 'Ok'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
