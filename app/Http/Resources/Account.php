<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Account extends JsonResource
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
            'code' => $this->ACCTCODE,
            'name' => trim($this->ACCTNAME),
            'address' => trim($this->ADDRESS) ? trim($this->ADDRESS):null,
            'email' => trim($this->BILLTO) ? trim($this->BILLTO):null,
            'tin' => trim($this->TIN),
            'orig' => parent::toArray($request),
        ];
    }
}
