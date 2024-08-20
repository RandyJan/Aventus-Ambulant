<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Outlet extends JsonResource
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
            'id' => (int)$this->OUTLETID,
            'branch_id' => $this->BRANCHID,
            'description' => trim($this->DESCRIPTION),
            'zone_id' => $this->ZONEID,
            'outlet_type' => $this->OUTLETTYPE,
            'division_id' => $this->DIVISIONID,
            'operation_unit_id' => $this->OPERATIONUNITID,
            'is_with_inventory' => $this->WithInventory == 1 ? true:false,
            'is_vatable' => $this->IsVatable == 1 ? true:false,
        ];
    }
}
