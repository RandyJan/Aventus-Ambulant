<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialReceipt extends Model
{
    use HasFactory;

    protected $table = 'GLHEADER';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'GLHID',        // incremental
        'GLTYPE',       // default: R
        'POSNO',        // id of device
        'empno',        // username in login
        'REFNUM',       // value of GLHID
        'REFDATE',      // clarion date
        'DATE',         // datetime
        'SUPPCODE',     // acctcode column in Accounts table
        'PAYEE',        // acctname column in Accounts table
        'BRANCHCODE',   // default: 1
        'amount',       // total of payments
        'COLLECTORID',  // ID in userdevices

        // Tax Computations

    ];

    /**
     * RELATIONSHIP
     */
    public function account(){
        return $this->belongsTo(Account::class, 'SUPPCODE', 'ACCTCODE');
    }

    public function collector(){
        return $this->belongsTo(User::class, 'COLLECTORID', 'ID');
    }

    /**
     * LOGIC
     */
    public function getNewID(){

        $result = static::orderBy('GLHID','desc')
            ->first();

        if( is_null($result)){
            return 1;
        }

        return $result->GLHID + 1;
    }
}
