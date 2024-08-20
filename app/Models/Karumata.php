<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karumata extends Model
{
    // use HasFactory;
    protected $table = 'Karumata';
    protected $connection = 'datalogic';
    public $timestamps = false;
}
