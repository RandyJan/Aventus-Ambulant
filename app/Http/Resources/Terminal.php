<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Terminal extends JsonResource
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
            'branch_id' => $this->STATIONCODE,
            'outlet_id' => $this->OUTLETID,
            'terminal_number' => $this->TERMNO,
            'description' => trim($this->DESC),
            'serial_number' => $this->SERIALNO,
            'type' => $this->TYPE,
        ];
    }
}
