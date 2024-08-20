<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderslipTable extends JsonResource
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
            'branch_id' => $this->BRANCHID,
            'outlet_id' => $this->OUTLETID,
            'device_id' => $this->DEVICENO,
            'orderslip_id' => $this->ORDERSLIPNO,
            'table_id' => $this->TABLENO,

            'table' => new TableFile( $this->whenLoaded('table') )
        ];
    }
}
