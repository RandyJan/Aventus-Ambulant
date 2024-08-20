<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderslipSenior extends Model
{
    use HasFactory;

    protected $table        = 'OrderSlipHeaderSeniors';
    protected $connection   = 'datalogic';
    protected $primaryKey   = 'ID';
    protected $keyType      = 'string';
    public $timestamps      = false;
    public $incrementing    = false;

    protected $fillable = [
        'ID',
        'BRANCH_ID',
        'OSNUMBER',
        'SEQUENCE',
        'SC_ID',
        'SC_NAME',
        'SC_ADDRESS',
    ];

    /**
     * Logic
     */
    public static function getSequence($orderslip_number){
        $result = static::where('OSNUMBER', $orderslip_number)
            ->orderBy('SEQUENCE', 'desc')
            ->first();

        if($result == null){
            return 1;
        }

        return $result->SEQUENCE + 1;
    }

    /**
     * Relationship
     */
}
