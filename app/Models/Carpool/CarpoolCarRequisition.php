<?php

namespace App\Models\Carpool;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarpoolCarRequisition extends Model
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




    // search
    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('start', 'LIKE', '%'.$val.'%')
        ->OrWhere('end', 'LIKE', '%'.$val.'%')
        ->OrWhere('status', 'LIKE', '%'.$val.'%')
        ->orWhereHas('car', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('driver', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        });
    }
}
