<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Postmix extends JsonResource
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
        return array_merge(
            [
                'parent_product_id' => $this->PRODUCT_ID,
                'parent_part_no' => trim($this->PARTNO),
                'child_product_id' => $this->PARTSID,
                'child_description' => trim($this->DESCRIPTION),
                'child_quantity' =>  (double)$this->QUANTITY,
                'child_unit_cost' => (double)$this->UNITCOST,
                'child_part_no' => $this->TYPE,
                'is_modifiable' => $this->MODIFIABLE ? true:false,
                'is_visible' => $this->DISPLAY ? true:false,
                'modified_quantity' => (double)$this->QUANTITY,

                'child_part' => Part::make($this->whenLoaded('childPart')),
                'group_code' => $this->whenLoaded('childPart', function(){
                    return trim($this->childPart->GROUP);
                }),
                'category_code' => $this->whenLoaded('childPart', function(){
                    return trim($this->childPart->CATEGORY);
                }),
                'location' => $this->whenLoaded('childPart', function(){
                    return trim( !empty($this->childPart->PRODGRP) ? $this->childPart->PRODGRP:'0' );
                }),
                'child_part_no' => $this->whenLoaded('childPart', function(){
                    return trim( !empty($this->childPart->PARTNO) ? $this->childPart->PARTNO:'' );
                }),
            ],
            // [
            //     'orig' => parent::toArray($request)
            // ],
        );
    }
}
