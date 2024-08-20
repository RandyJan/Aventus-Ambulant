<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderSlip extends Model
{
    use HasFactory;
    protected $table = 'OrderSlips';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'BRANCHID',
        'OUTLETID',
        'DEVICEID',
        'ORDERSLIPID',
        'DATE',
        'TIME',
        'ASSESSORID',
        'TOTALAMOUNT',
        'TOTALITEMS',
        'INACTIVE',
        'SUPPLIERID',
        'VENDORID',
        'ORDERSLIPCODE',
        'CREATED_AT',
        'IMAGE'
    ];

    protected $appends = [
        'selected_type',
        'created_time'
    ];

    /**
     * Accessors
     */
    public function getSelectedTypeAttribute(){
        $type = 'EMPTY';

        if($this->supplier != null || $this->supplier != 0){
            $type =  $this->supplier->COMPANY;
        }
        if($this->ambulantVendor != null || $this->ambulantVendor != 0){
            $type = $this->ambulantVendor->NAME;
        }

        return Str::words($type, 3, '...');
    }

    public function getCreatedTimeAttribute(){
        $time = null;

        if(!$this->attributes['CREATED_AT'] == null){
            $carbon = Carbon::parse($this->attributes['CREATED_AT']);

            $time = $carbon->format('h:i a');
        }

        return $time;
    }


    /**
     * Logics
     */
    public function getNewId($branch_id=null,$outlet_id=null,$device_no=null){
        $result = static::where('BRANCHID', $branch_id)
            ->where('OUTLETID', $outlet_id)
            ->where('DEVICEID', $device_no)
            ->orderBy('ORDERSLIPID','desc')
            ->first();

        if( is_null($result)){
            return 1;
        }
        return $result->ORDERSLIPID + 1;
    }

    public function activeHeaderSlip($orderslipcode,$branchId,$outlet,$deviceID){

        $filtered =  $this->hasMany('App\Models\OrderSlipHeader','ORDERSLIPCODE','ORDERSLIPCODE')
                ->where('ORDERSLIPCODE',$orderslipcode)
                ->where('BRANCHID', $branchId)
                ->where('OUTLETID',$outlet)
                ->where('DEVICENO', $deviceID)
                ->where('INACTIVE', 1)
                ->first();
        // dd( $filtered );
        return $filtered;
    }

    /**
     * Relationship
     */
    public function headers(){
        return $this->hasMany(OrderSlipHeader::class, 'ORDERSLIPCODE', 'ORDERSLIPCODE');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'SUPPLIERID', 'SUPPID');
    }
    public function ambulantVendor(){
        return $this->belongsTo(Customers::class, 'VENDORID', 'CUSTOMERID');
    }
}
