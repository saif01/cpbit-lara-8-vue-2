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
        // return "{$this->first_name} {$this->last_name}"; 
        return $this->purpose;
    }

    public function room(){
        // return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
        return $this->belongsTo('App\Models\Room\Room', 'room_id', 'id');
    }

    public function bookby(){
        // return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
