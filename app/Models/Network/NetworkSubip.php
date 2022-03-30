<?php

namespace App\Models\Network;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkSubip extends Model
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
}
