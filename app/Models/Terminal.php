<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $table        = 'HOSiteTerminals';
    protected $primaryKey   = 'ID';
    protected $connection   = 'datalogic';

    /**
     * Relationships
     */
    public function branch(){
        return $this->belongsTo(Branch::class, 'STATIONCODE', 'BRANCHID');
    }

    public function outlet(){
        return $this->belongsTo(Outlet::class, 'OUTLETID', 'OUTLETID')
            ->where('BRANCHID', $this->STATIONCODE);
    }

}
