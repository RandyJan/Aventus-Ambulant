<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupSize extends Model
{
    use HasFactory;
    protected $table = 'GroupSizs';
    public $timestamp = false;
    protected $connection = 'datalogic';

}
