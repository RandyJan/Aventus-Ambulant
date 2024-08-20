<?php

namespace App\Http\Resources;

use App\Http\Resources\Terminal as ResourcesTerminal;
use App\Models\OrderslipTable;
use App\Models\Terminal;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class OrderSlipHeader extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $self = $this;

        return array_merge(
            [
                'user_current_transaction' => $this->USER_CURRENT_TRANSACTION,
                'branch_id' => $this->BRANCHID,
                'outlet_id' => $this->OUTLETID,
                'device_id' => $this->DEVICENO,
                'orderslip_id' => $this->ORDERSLIPNO,
                'orderslip_code' => $this->OSNUMBER,
                'plate_number' => trim($this->QUEUEDNAME),
                'encoded_by' => $this->ENCODEDBY,
                'prepared_by' => trim($this->PREPAREDBY),
                'is_paid' => $this->PAID == 1 ? true : false,
                'total_amount' => $this->TOTALAMOUNT,
                'net_amount' => $this->NETAMOUNT,
                'status' => $this->STATUS,
                'created_date' => $this->created_date,
                'created_time' => $this->created_time,
                'terminal' => new ResourcesTerminal($this->whenLoaded('terminal')),
                'duration' => computeDuration( Carbon::parse($this->OSDATE), $this->QDATE ),
                'created_at' => $this->OSDATE,
                'completed_at' => $this->QDATE,

                'vatable_sales'     => $this->VATABLE_SALES,
                'vat_amount'        => $this->VAT_AMOUNT,
                'sc_discount_percentage'    => $this->SC_DISCOUNT_PERCENTAGE,
                'sc_discount_amount'        => $this->SC_DISCOUNT_AMOUNT,
                'customer_name'             =>$this->CUSTOMERNAME,
                'tables' => $this->when(config('settings.app_type') == 'restaurant_ambulant', function() use($self){
                    // Log::debug('RESOURCE', [$self->BRANCHID]);
                    $tables = OrderslipTable::with(['table' => function($q) use($self){
                        $q->where('BRANCH_ID', $self->BRANCHID);
                    }])
                        ->where('BRANCHID', $self->BRANCHID)
                        ->where('OUTLETID', $self->OUTLETID)
                        ->where('DEVICENO', $self->DEVICENO)
                        ->where('ORDERLIPNO', $self->ORDERSLIPNO)
                        ->get();

                    return implode(', ', $tables->pluck('table.TABLECODE')->map(function($data){
                            return trim($data);
                        })->toArray()
                    );
                }),
            ],
            // parent::toArray($request)
        );
    }
}
