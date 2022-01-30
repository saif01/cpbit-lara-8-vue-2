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

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('login', 'LIKE', '%'.$val.'%')
        ->Orwhere('name', 'LIKE', '%'.$val.'%')
        ->Orwhere('office_id', 'LIKE', '%'.$val.'%')
        ->Orwhere('department', 'LIKE', '%'.$val.'%')
        ->Orwhere('business_unit', 'LIKE', '%'.$val.'%'); 
    }


    //Relation user to role
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    // Check Array of roles
    public function hasAnyRoles($roles)
    {
        if($this->roles()->whereIn('name',$roles)->first()){
            return true;
        }
        return false;
    }

    // Check single roles
    public function hasRole($role)
    {
        if($this->roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }



    //Relation user to sms role
    public function sms_roles()
    {
        return $this->belongsToMany('App\Models\Sms\SmsOperation');
    }

    // Check single roles sms
    public function sms_hasRole($role)
    {
        if($this->sms_roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }

    

    
}
