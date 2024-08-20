<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table        = 'groups';
    protected $primaryKey   = 'GROUPCODE';
    protected $keyType      = 'string';
    public $timestamps      = false;
    protected $connection   = 'datalogic';

    /**
     * Relationships
     */
    public function partLocation(){
        return $this->hasMany(PartLocation::class, 'GROUP');
    }
}
