<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Set;

class OrderSlipHeader extends Model
{
    protected $table = 'OrderSlipHeader';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'ORDERSLIPNO',
        'BRANCHID',
        'OUTLETID',
        'DEVICENO',
        'STATUS',                   // default: 'X'
        'DISPLAYMONITOR',           // default: 2
        'QUEUEDNAME',               // plate number
        'ENCODEDBY',                // id of the user
        'PREPAREDBY',               // name of the  user
        'CCENAME',                  // name of the  user
        'ISACTIVE',                 // current os transaction identifier
        'TRANSACTTYPEID',           // default: 1
        'OSDATE',                   // default: now()
        'ORIGINALINVOICEDATE',      // default: now() in clarion
        'ENCODEDDATE',              // default: now()
        'OSNUMBER',                 // default: XXX-XXXXXXXXXX = {branchId}{deviceId}-{YY-MM-DD}{00001}
        'PAID',                     // default: 0  | paid=1, unpaid=0
        'USER_CURRENT_TRANSACTION', // default: null , this is to identify the user current transaction.
        'BUSDATE',                  // this is shift business date converted in clarion
        'QDATE',                    // use to compute the time duration between OSDATE and this will serve as completed.
        'TOTALAMOUNT',
        'NETAMOUNT',
        'IS_SC',
        'ACCOUNTTYPE',              // identifier for confirmed order
        'OSTYPE',                   // 1 = "DINE IN" , 2 = "TAKE OUT"
        'SERVICE_CHARGE_AMT',
        'SERVICE_CHARGE_PERCENTAGE',
        'CUSTOMERNAME'
    ];

    protected $appends = [
        'created_time',
        'created_date'
    ];

    /**
     * Accessors
     */
    public function getCreatedTimeAttribute()
    {
        $time = null;

        if (!$this->attributes['OSDATE'] == null) {
            $carbon = Carbon::parse($this->attributes['OSDATE']);

            $time = $carbon->format('h:i a');
        }

        return $time;
    }

    public function getCreatedDateAttribute()
    {
        $date = null;

        if (!$this->attributes['OSDATE'] == null) {
            $carbon = Carbon::parse($this->attributes['OSDATE']);

            $date = $carbon->format('Y-m-d');
        }

        return $date;
    }

    /**
     * Logics
     */

    public static function getNewId($branch_id=null, $outlet_id=null, $device_no=null){
        $result = static::where('BRANCHID', $branch_id)
              ->where('OUTLETID', $outlet_id)
              ->where('DEVICENO', $device_no)
              ->orderBy('ORDERSLIPNO','desc')
              ->first();

          if( is_null($result)){
              return 1;
          }

          return $result->ORDERSLIPNO + 1;
      }



    /**
     * Relationships
     */
    public function details()
    {
        return $this->hasMany(OrderSlipDetails::class, 'ORDERSLIPHEADERCODE', 'ORDERSLIPHEADERCODE');
    }
    public function vendor()
    {
        return $this->belongsTo(Customers::class, 'VENDORID', 'CUSTOMERID');
    }
    public function terminal()
    {
        return $this->belongsTo(Terminal::class, 'DEVICENO', 'ID');
    }
}
