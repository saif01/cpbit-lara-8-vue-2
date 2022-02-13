<?php

namespace App\Models\Carpool;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\User;
use App\Models\Carpool\CarpoolCar;
use App\Models\Carpool\CarpoolLeaves;

class CarpoolDriver extends Model
{


    use HasFactory;


    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }





    //User
    public function user()
    {
    	return $this->belongsTo(User::class, 'delete_by');
    }

    //car
    public function car()
    {
    	return $this->belongsTo(CarpoolCar::class, 'car_id');
    }


    // leave
    public function leave()
    {
       return $this->hasMany( CarpoolLeaves::class, 'driver_id', 'id');

    }

    // //maintenance
    // public function maintenance()
    // {
    //    return $this->hasMany( CarpoolLeaves::class, 'driver_id', 'id');
    // }


    // //requisition
    // public function requisition()
    // {
    //    return $this->hasMany( CarpoolLeaves::class, 'driver_id', 'id');
    // }

}
