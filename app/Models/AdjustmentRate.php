<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentRate extends Model
{
    use HasFactory;
    protected $table = "AdjustmentRate";
    protected $connection = "datalogic";
}
