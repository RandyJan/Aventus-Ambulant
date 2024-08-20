<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Invoice extends JsonResource
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
            'invoice_number' => $this->INVNUM,
            'reference_number' => $this->REFERENCENO,
            'transaction_code' => $this->TRANSCODE,
            'reference_date' => $this->REFDATE,
            'due_date' => $this->DUEDATE,
            'transaction_type' => $this->TRANTYPE,
            'transaction_number' => $this->TRANNUM,
            'orign' => parent::toArray($request)
        ];
    }
}
