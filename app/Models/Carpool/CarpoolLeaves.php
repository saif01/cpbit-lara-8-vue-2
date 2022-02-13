<?php

namespace App\Models\Carpool;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpoolLeaves extends Model
{
    use HasFactory;


    public function car()
    {
    	return $this->belongsTo('App\Models\Carpool\CarpoolCar', 'car_id');
    }

    public function driver()
    {
    	return $this->belongsTo('App\Models\Carpool\CarpoolDriver','driver_id');
    }

}
