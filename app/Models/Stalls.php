<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stalls extends Model
{
    // use HasFactory;
    protected $table = 'stalls';
    protected $connection  = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    public function scopeActive($q){
        return $q->where('INACTIVE', 0)
            ->WHERE('STATUS', 1);
    }
}
