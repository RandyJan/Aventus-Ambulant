<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSlipDetail extends Model
{
    use HasFactory;

    protected $table = 'OrderSlipDetails';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'OSNUMBER',
        'ORDERSLIPNO',
        'ORDERSLIPDETAILID',
        'BRANCHID',
        'OUTLETID',
        'DEVICENO',
        'PRODUCT_ID',
        'RETAILPRICE',
        'QUANTITY',
        'REQUESTEDQTY', // same value of QUANTITY upon creating
        'AMOUNT',
        'NETAMOUNT',
        'REMARKS',
        'PARTNO',
        'LINE_NO',
        'ORNO',         // similar to LINE_NO
        'OSTYPE',       // 1=dinein, 2=takeout, 3=bulk-order, 4=others
        'STATUS',       // X = to be able to see in the kitchen and process'
        'SEQUENCE',     // Sequence per product
        'OSDATE',
        'LOCATIONID',
        'ENCODEDDATE',
        'DISPLAYMONITOR',   // default: 1
        'POSLINENO',    // similar to LINE_NO
        'MAIN_PRODUCT_ID',
        'MAIN_PRODUCT_COMPONENT_ID',
        'MAIN_PRODUCT_COMPONENT_QTY',
        'CUSTOMERNAME',
        'CUSTOMERCODE',
        'DEV_MOD', // id of the device which modifies the order after taking over
        'GUESTNO',
        'GUEST_TYPE',
        'POSTMIXID',
        'MEAL_STUB_PRODUCT_ID',
        'MEAL_STUB_SERIAL_NUMBER',
        'TABLENO',
        'OS_SC_ID',
        'IS_MODIFY',

        'VATABLE_SALES',
        'VAT_AMOUNT',
        'SC_DISCOUNT_PERCENTAGE',
        'SC_DISCOUNT_AMOUNT',
        'SC_COUNT',
        'REG_COUNT',
        'VAT_EX',
        'IS_GROUP_MEAL',
        'GROUP_SERVING',
        'DISCOUNTID',
        'CONFIRMED_AT',     // identifier for confirmed order
        'PRODUCTGROUP',
        'PSTATUS',          // identifier for confirmed order
    ];

    /**
     * Accessors
     */

    /**
     * Relationships
     */
    public function product(){
        return $this->belongsTo(Part::class, 'PRODUCT_ID', 'PRODUCT_ID');
    }
    public function stall(){
        return $this->belongsTo(Stalls::class, 'STALLID', 'STALLID');
    }
    public function karumata(){
        return $this->belongsTo(Karumata::class, 'KARUMATAID', 'KARUMATAID');
    }
    public function group(){
        return $this->belongsTo(Group::class, 'GROUPCODE', 'GROUPCODE');
    }
    public function os_sc(){ // orderslip senior citizen
        return $this->belongsTo(OrderslipSenior::class, 'OS_SC_ID', 'ID');
    }
    public function header(){
        return $this->belongsTo(OrderSlipHeader::class, 'OSNUMBER', 'OSNUMBER');
    }

    /**
     * Logic
     */
    public static function getNewDetailId($orderslip_number){

        $result = static::where('OSNUMBER',$orderslip_number)
                    ->orderBy('LINE_NO','desc')
                    ->first();

        if( is_null($result)){
            return 1;
        }
    	return $result->ORDERSLIPDETAILID + 1;
    }

    public static function getNewProductSequence($orderslip_number, $product_id){
        $result = static::where('OSNUMBER', $orderslip_number)
            ->where('MAIN_PRODUCT_ID', $product_id)
            ->orderBy('SEQUENCE', 'desc')
            ->first();

        if($result == null){
            return 1;
        }

        return $result->SEQUENCE + 1;
    }

    public static function getNewLineNumber($orderslip_number){
        $result =  static::where('OSNUMBER',$orderslip_number)
            ->orderby('LINE_NO','desc')
            ->first();

        if($result == null){
            return 1;
        }

        return $result->LINE_NO + 1;
    }

}
