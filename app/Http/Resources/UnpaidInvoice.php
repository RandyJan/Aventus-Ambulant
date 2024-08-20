<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnpaidInvoice extends JsonResource
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
        return [
            'transaction_number' => $this->TRANNUM,
            'formatted_transaction_number' => str_pad($this->TRANNUM, 7, "0", STR_PAD_LEFT),
            'invoice_number' => $this->REFERENCENO,
            'reference_date' => $this->REFDATE,
            'account' => $this->when( trim($this->SUPPCODE) != '0', Account::make($this->account), null ),
            'balance' => $this->BALANCE,
            'tx_type' => $this->TXTYPE,
            'orign' => parent::toArray($request)
        ];
    }
}
