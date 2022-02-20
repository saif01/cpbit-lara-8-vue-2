<?php

namespace App\Models\Carpool;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Carpool\CarpoolDriver;
use Carbon\Carbon;

class CarpoolCar extends Model
{
    use HasFactory;


    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }


    public function car_leave(){
        return $this->hasMany('App\Models\Carpool\CarpoolLeaves', 'car_id', 'id')->whereDate('start', '>=', Carbon::now());
    }

    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }




    public function driver()
    {
    	return $this->hasOne(CarpoolDriver::class, 'car_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'delete_by');
    }



}
