<?php

namespace App\Models\iTemp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class itempEmployeeTemp extends Model
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
