<?php

namespace App\Models\Room;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    use HasFactory;

    // Appends New Field
    protected $appends = ['title'];

    // Modify New appends field
    public function getTitleAttribute()
    {
        if ($this->room && $this->bookby) {
            return "{$this->room->name} {$this->purpose}" ." ( ". $this->bookby->name ." )";
        } else {
            return "{$this->purpose}" ;
        }

        //return "{$this->room->name} {$this->purpose}" ." ( ". $this->bookby->name ." )";
    }

    public function room(){
        return $this->belongsTo('App\Models\Room\Room', 'room_id', 'id');
    }

    public function bookby(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('start', 'LIKE', '%'.$val.'%')
        ->OrWhere('end', 'LIKE', '%'.$val.'%')
        ->OrWhere('purpose', 'LIKE', '%'.$val.'%')
        ->orWhereHas('room', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('bookby', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('bookby', function($query) use ($val){
            $query->WhereRaw('department LIKE ?', '%'.$val.'%');
        }); 
    }

}
