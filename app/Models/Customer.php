<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'Customer';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'BRANCHORIGIN',
        'CUSTNO',
        'CUSTOMERTYPE',
        'CUSTOMERCODE',
        'EMAILADDRESS',
        'INACTIVE',
    ];

    public function scopeActive($query)
    {
        return $query->where('INACTIVE', 0);
    }

    public function scopeFilter($query, $payload)
    {
        // dd(
        //     $payload,
        // );
        $query->when(!empty($payload['filter_search']), function ($q) use ($payload) {
            $q->where('COMPANY', 'LIKE', "%" . $payload['filter_search'] . "%");
        })
        ->when(!empty($payload['filter_branch']), function ($q) use ($payload) {
            $q->where('BRANCHORIGIN', $payload['filter_branch']);
        })
        ;
    }
}
