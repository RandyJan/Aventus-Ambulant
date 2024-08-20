<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderslipTable extends Model
{
    use HasFactory;

    protected $table = 'tablehistory';
    protected $connection = 'datalogic';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'BRANCHID',
        'OUTLETID',
        'DEVICENO',
        'ORDERLIPNO',
        'TABLENO',
        'CREATED',
        'CDATE',
        'CTIME',
        'BUSDATE',
        'SNR',
        'PWD',
        'ZERO',
        'REG',
        'ACTUALHEADS',
        'TOTALHEADS',
        'FROMTABLENO',
        'STATUS',
        'MERGED',
        'MERGEID',
        'POSNUMBER',
    ];

    public function table(){
        return $this->belongsTo(TableFile::class, 'TABLENO', 'TABLENO');
    }
}
