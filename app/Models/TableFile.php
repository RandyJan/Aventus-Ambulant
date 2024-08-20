<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableFile extends Model
{
    use HasFactory;

    protected $table        = 'tablefile';
    protected $connection   = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;
}
