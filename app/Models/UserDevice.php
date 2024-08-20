<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $table        = 'UserDevices';
    protected $primaryKey   = 'ID';
    protected $connection   = 'datalogic';

    protected $fillable = [
        'ID',
        'NAME',
        'PW',
        'NUMBER',
        'DEVICENO',         // this is the serial number of the device
        'DEVICEID',         // this is the ID of HOSiteTerminal
        'OUTLETID',
        'BRANCHID',
        'INACTIVE',
    ];

    /**
     * Relationships
     */
    public function branch(){
        return $this->belongsTo(Branch::class, 'BRANCHID', 'BRANCHID');
    }

    public function outlet(){
        return $this->belongsTo(Outlet::class, 'OUTLETID', 'OUTLETID')
            ->where('BRANCHID', $this->BRANCHID);
    }

    public function terminal(){
        return $this->belongsTo(Terminal::class, 'DEVICENO');
    }


}
