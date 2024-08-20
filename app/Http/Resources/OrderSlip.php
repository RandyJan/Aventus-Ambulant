<?php

namespace App\Http\Resources;
use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderSlip extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return parent::toArray($request);

    }
}
