<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModeOfPayment extends JsonResource
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
            'orig' => parent::toArray($request),
            'id' => $this->ID,
            'description' => trim($this->DESC),
            'require_reference_no' => $this->REFNO == 1 ? true : false,
        ];
    }
}
