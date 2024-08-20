<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'Locations';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'PRODGROUP_ID',
        'DESCRIPTION',
        'PRINTER_NAME',
        'PRINTER_IP',
        'PRINTER_PAPER_WIDTH',
        'UNITMEASURE',
    ];
}
