<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use NumberFormatter;

class OfficialReceipt extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        return [
            'id' => $this->GLHID,
            'formatted_id' => str_pad($this->GLHID, 11, "0", STR_PAD_LEFT),
            'formatted_date' => Carbon::parse($this->DATE)->format('M d, Y'),
            'formatted_amount' => number_format($this->AMOUNT, 2),
            'formatted_vatable_sales' => number_format($this->VATABLESALES, 2),
            'formatted_vat_amount' => number_format($this->VATAMOUNT, 2),
            'formatted_vat_exempt' => number_format($this->VATEXEMPT, 2),
            'formatted_zero_rated' => number_format($this->ZERORATED, 2),
            'formatted_sc_pwd_discount' => number_format($this->SCPWDDISCOUNT, 2),
            'formatted_net_due' => number_format($this->NETDUE, 2),
            'formatted_net_amount' => number_format($this->NETAMOUNT, 2),
            'formatted_spelled_amount' => ucwords( $f->format($this->AMOUNT) ),
            'formatted_date_time' => Carbon::parse($this->DATE)->format('M d, Y g:ia'),
            'account_code' => trim($this->SUPPCODE),
            'account' => $this->when( trim($this->SUPPCODE) != '0', Account::make($this->account), null ),
            'collector' => $this->when( $this->COLLECTORID , User::make($this->collector), null ),
            'orig' => parent::toArray($request),
        ];
    }
}
