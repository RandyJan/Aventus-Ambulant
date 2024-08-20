<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table        = 'Customers';
    public $timestamps      = false;
    protected $fillable = ['MOBILE_NUMBER'];
    protected $connection = 'datalogic';


    public function scopeIsVendor($query){
        return $query->where('CUSTOMETYPE',9);
    }

    public function scopeActive($q){
        return $q->where('INACTIVE', 0)
            ->where('STATUS', 1);
            // ->where('STALLCODE', '!=', '');
    }

    public function scopeStallCodeNotEmpty($q){
        return $q->whereNotNull('STALLCODE')
            // ->orWhere('STALLCODE', '<>', '');
            ->where('STALLCODE', '!=', '');
    }
}
