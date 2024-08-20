<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartLocation extends Model
{
    use HasFactory;

    protected $table        = 'PartsLocation';
    protected $connection   = 'datalogic';

    protected $fillable = [
        'PRODUCT_ID',
        'OUTLETID',
        'DESCRIPTION',
        'GROUP',
        'CATEGORY',
        'SHORTCODE',
        'RETAIL',
        'POSTMIX',
        'PREPARTNO',
        'SSBUFFER',
        'MSGROUP',
        'QUANTITY',
        'PRODGRP',
        'PARTNO',
        'BRANCHID',
        'BUSUNIT',
        'MASTERCODE'
    ];

    /**
     * Relationship
     */
    public function part(){
        return $this->belongsTo(Part::class, 'PRODUCT_ID');
    }

    /**
     * Accessor
     */
    public function getImageUrlAttribute(){

    }
}
