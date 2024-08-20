<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchCustomer extends JsonResource
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
            'branch_id' => $this->BRANCHORIGIN,
            'customer_no' => $this->CUSTNO,
            'customer_name' => trim($this->COMPANY),
            'customer_type' => trim($this->CUSTOMERTYPE),
            'customer_code' => trim($this->CUSTOMERCODE),
            'email_address' => trim($this->EMAILADDRESS),
            'address' => trim($this->ADDRESS),
            'in_active' => $this->INACTIVE,
        ];
    }
}
