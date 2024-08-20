<?php

namespace App\Http\Resources;

use App\Models\SitePart;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PartLocation extends JsonResource
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
            'branch_id' => $this->BRANCHID,
            'outlet_id' => $this->OUTLETID,
            'product_id' => $this->PRODUCT_ID,
            'product_description' => trim($this->DESCRIPTION),
            'short_description' => trim($this->SHORTCODE),
            'cost' => $this->COST,
            'retail' => (double)$this->RETAIL,
            'status' => $this->STATUS,
            'master_code' => $this->MASTERCODE,
            'bs_unit' => $this->BSUNIT,
            'group' => trim($this->GROUP),
            'category' => trim($this->CATEGORY),
            'part_number' => trim($this->PARTNO),
            'is_vatable' => $this->whenLoaded('part', function(){
                return $this->part->VAT == 1? 1:0;
            }),
            'is_less_vat_for_scpwd' => $this->whenLoaded('part', function(){
                return $this->part->TIMPLADOS == 1? 1:0;
            }),
            'sc_discount_percentage' => $this->whenLoaded('part', function(){
                return (double)$this->part->STDCARCASSWEIGHT;
            }),
            'img_path' => $this->part ? ($this->part->IMAGE ? Storage::url($this->part->IMAGE) : '/assets/default-product.png') : '/assets/default-product.png',
            // 'img_path' =>  '/assets/default-product.png',
            'is_postmix' => !empty($this->POSTMIX) ? true:false,
            'location' => !empty($this->PRODGRP) ? $this->PRODGRP:'0',

            'is_group_meal' => $this->whenLoaded('part', function(){
                return $this->part->ISGROUPMEAL != null ? (int)$this->part->ISGROUPMEAL : 0;
            }),
            'group_serving' => $this->whenLoaded('part', function(){
                return $this->part->GROUPSERVINGS != null ? (int)$this->part->GROUPSERVINGS : 0;
            }),
        ];
    }
}
