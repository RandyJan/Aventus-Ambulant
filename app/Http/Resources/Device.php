<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Device extends JsonResource
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
            'id' => $this->ID,
            'terminal_number' => $this->TERMNO,
            'description' => trim($this->DESC),
            'branch_id' => $this->STATIONCODE,
            'serial_number' => $this->SERIALNO,
            'outlet_id' => $this->OUTLETID,
            'type' => $this->TYPE,
        ];
    }
}
