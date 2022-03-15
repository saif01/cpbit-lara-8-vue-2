<?php

namespace App\Models\Pbi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbiRole extends Model
{
    use HasFactory;

    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    //For Dynamic Search 
    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }
}
