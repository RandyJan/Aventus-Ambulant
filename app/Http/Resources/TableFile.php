<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TableFile extends JsonResource
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
            'branch_id' => $this->BRANCH_ID,
            'table_id' => $this->TABLE_ID,
            'table_no' => $this->TABLENO,
            'table_code' => trim($this->TABLECODE),
            'description' => trim($this->DESCRIPTION),
            'can_merge' => $this->CANMERGE,
            'movable' => $this->MOVEABLE,
            'guests' => $this->GUESTS,
            'os_number' => $this->OSNUMBER
        ];
    }
}
