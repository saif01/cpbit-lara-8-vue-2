<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareAcsosoris extends Model
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
