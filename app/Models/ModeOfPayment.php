<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeOfPayment extends Model
{
    use HasFactory;

    protected $table = 'mop';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;
}
