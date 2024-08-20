<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Branch extends JsonResource
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
        return [
            'id' => $this->BRANCHID,
            'branch_name' => trim($this->BRANCHNAME),
            'type' => $this->TYPE,
            'cost_center_code' => trim($this->COSTCENTERCODE),
            'company_id' => $this->COMPANYID,
            'is_vatable' => $this->IsVatable == 1 ? true:false,
        ];
    }
}
