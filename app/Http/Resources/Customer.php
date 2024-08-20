<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
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
        return[
            'id' =>$this->CUSTOMERID,
            'code' =>$this->CUSTOMERCODE,
            'vendor' =>$this->NAME,
            'stall' =>$this->STALLCODE,
            'stallId' =>$this->STALLID,
            'location' => $this->MARKETLOCATIONNAME,
            'locationId' => $this->MARKETLOCATIONID
        ];
    }
}
