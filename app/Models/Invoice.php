<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [

    ];

    /**
     * RELATIONSHIP
     */
    public function account(){
        return $this->belongsTo(Account::class, 'ACCTCODE', 'ACCTCODE');
    }

    /**
     * Scope
     */
    public function scopeUnpaidInvoice($q, $account_code){
        $q->where('ACCTCODE', $account_code)
            ->where('INVTYPE', 'I')
            ->where('BALANCE', '>', 0);
    }
}
