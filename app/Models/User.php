<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table        = 'UserSite';
    protected $primaryKey   = 'ID';
    protected $connection   = 'datalogic';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ID',
        'NUMBER', // username
        'PW', // password
        'TOKEN',
        'NAME',
        'OUTLETID',
        'DEVICENO',
        'BRANCHID',
        'LEVEL'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Accessors
     */
    public function getCanVoidAttribute(){
        return $this->attributes['AUTH:VOID'];
    }

    /**
     * Scopees
     */
    public function scopeFindByUsername($q, $username){
        return $q->where('NUMBER', $username);
    }

    /**
     * Relationships
     */
    public function devices(){
        return $this->hasMany(UserDevice::class, 'ID');
    }


    public function activeSlip($branchId,$outlet,$deviceID){

        $filtered =  $this->hasMany('App\Models\OrderSlip','ASSESSORID','NUMBER')
                ->where('BRANCHID', $branchId)
                ->where('OUTLETID',$outlet)
                ->where('DEVICEID', $deviceID)
                ->where('INACTIVE', 0)
                ->first();

        // dd( $filtered );
        return $filtered;
      }
}
