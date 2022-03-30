<?php

namespace App\Models\Network;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkMainip extends Model
{
    use HasFactory;
    
    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }


    protected $appends = ['pingType'];

    // Modify New appends field
    public function getPingTypeAttribute()
    {

        if( $this->start == '09:00:00' && $this->end == '18:00:00' ){
            return 'OfficeTime';
        } elseif( $this->start == '06:00:00' && $this->end == '18:00:00'  ){
            return 'fullDay';
        }elseif( $this->start == '18:00:00' && $this->end == '06:00:00'  ){
            return 'fullNight';
        }elseif( $this->start == '01:01:01' && $this->end == '23:59:59'  ){
            return 'dayNight';
        }else{
            return '';
        }
    }



    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }
}
