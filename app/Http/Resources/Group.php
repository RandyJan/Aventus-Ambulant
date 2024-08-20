<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class Group extends JsonResource
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
        // BSUNITCODE: "LOC       "
        // DESCRIPTION: "CHATIME                                           "
        // GROUPCODE: "1         "
        // MASTERCODE: "1"
        // METROMARKUP: ".00"
        // PROVMARKUP: ".00"

        return array_merge(
            [
                'group_code' => trim($this->GROUPCODE),
                'bs_unit_code' => trim($this->BSUNITCODE),
                'description' => trim($this->DESCRIPTION),
                'slug' =>  Str::slug(trim($this->DESCRIPTION)),
            ],
            // parent::toArray($request)
        );
    }
}
