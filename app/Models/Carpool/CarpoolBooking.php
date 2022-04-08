<?php

namespace App\Models\Carpool;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpoolBooking extends Model
{
    use HasFactory;

    // Appends New Field
    protected $appends = ['title'];

    //Modify New appends field
    public function getTitleAttribute()
    {
        if ($this->driver && $this->bookby) {
            return "{$this->driver->name} " ." ( ". $this->bookby->name ." ) {$this->purpose}";
        } else {
            return "{$this->purpose}" ;
        }
        
        //return "{$this->car->name} {$this->purpose}" ." ( ". $this->bookby->name ." )";
       // return "asdfsdgsdgsdfgdf";
    }
 
    public function car(){
        return $this->belongsTo('App\Models\Carpool\CarpoolCar', 'car_id', 'id');
    }

    public function bookby(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // leave
    public function leave(){
        return $this->belongsTo('App\Models\Carpool\CarpoolLeaves', 'car_id', 'car_id');
    }

    //driver
    public function driver()
    {
    	return $this->belongsTo('App\Models\Carpool\CarpoolDriver', 'car_id', 'car_id');
    }


    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('start', 'LIKE', '%'.$val.'%')
        ->OrWhere('end', 'LIKE', '%'.$val.'%')
        ->OrWhere('destination', 'LIKE', '%'.$val.'%')
        ->OrWhere('purpose', 'LIKE', '%'.$val.'%')
        ->OrWhere('status', 'LIKE', '%'.$val.'%')
        ->OrWhere('gas', 'LIKE', '%'.$val.'%')
        ->OrWhere('octane', 'LIKE', '%'.$val.'%')
        ->OrWhere('toll', 'LIKE', '%'.$val.'%')
        ->OrWhere('cost', 'LIKE', '%'.$val.'%')
        ->OrWhere('start_mileage', 'LIKE', '%'.$val.'%')
        ->OrWhere('km', 'LIKE', '%'.$val.'%')
        ->OrWhere('driver_rating', 'LIKE', '%'.$val.'%')
        ->orWhereHas('car', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('bookby', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('driver', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        }); 
    }

}
