<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postmix extends Model
{
    use HasFactory;

    protected $table        = 'Postmix';
    protected $connection   = 'datalogic';

    protected $fillable = [
        'PRODUCT_ID',           // parent
        'PARTNO',
        'PARTSID',              // child
        'PARTSPARTNO',
        'QUANTITY',
        'UNITCOST',
        'UNITCOSTC',
        'EXTENDCOST',
        'EXTENDCOSTC',
        'TYPE',
        'DESCRIPTION',
        'RAWMATERIAL',
        'STD_UM',
        'YIELD',
        'ISFREE',
        'MODIFIABLE',
        'COMPCATID',
        'STUB',
        'DISPLAY',
        'PACKAGING',
        'RCTITEMCOUNT',
        'PRINTRECEIPT',
        'Ticket',
        'Mealstub',
        'VOUCHER',
        'NOAMOUNT',
        'TEMPLATEID',
        'UPLOADED',
    ];

    /**
     * Relationship
     */
    public function parentPart(){
        return $this->belongsTo(Part::class, 'PRODUCT_ID');
    }
    public function childPart(){
        return $this->belongsTo(Part::class, 'PARTSID');
    }
}
