<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteParts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'productId' => $this->PRODUCT_ID,
            'shortCode' => $this->SHORTCODE,
            'retail' => $this->RETAIL
        ];
    }
}
