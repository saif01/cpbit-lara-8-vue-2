<?php

namespace App\Models\iTemp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itempEmployee extends Model
{
    use HasFactory;

    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function temp(){
        return $this->belongsTo('App\Models\iTemp\itempEmployeeTemp', 'id', 'emp_id');
    }

    
    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }

}
