<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;


    /**
     * SCOPES
     */
    public function scopeActive($query)
    {
        return $query->where('STATUS', 'Y');
    }

    public function scopeFilter($query, $payload)
    {
        $query->when(!empty($payload['filter_search']), function ($q) use ($payload) {
            $q->where('ACCTNAME', 'LIKE', "%" . $payload['filter_search'] . "%");
        })
        ;
    }
}
