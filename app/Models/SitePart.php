<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePart extends Model
{
    use HasFactory;

    protected $table = 'SiteParts';
    protected $connection = 'datalogic';
}
