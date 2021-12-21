<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReginster extends Model
{
    use HasFactory;

    public function verified()
    {
        return $this->belongsTo('App\Models\User', 'verify_by', 'id');
    }




    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('login', 'LIKE', '%'.$val.'%')
        ->Orwhere('name', 'LIKE', '%'.$val.'%')
        ->Orwhere('office_id', 'LIKE', '%'.$val.'%')
        ->Orwhere('department', 'LIKE', '%'.$val.'%')
        ->Orwhere('business_unit', 'LIKE', '%'.$val.'%'); 
    }
}
