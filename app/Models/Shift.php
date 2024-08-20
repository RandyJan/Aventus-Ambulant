<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'branch_id',
        'outlet_id',
        'terminal_id',
        'business_date',
        'employee_number',
        'shift_count',
        'shift_posted',
        'shift_posted_at',
        'day_posted',
        'day_posted_at',
        'day_posted_by'
    ];
}
