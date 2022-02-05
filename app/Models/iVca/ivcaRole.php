<?php

namespace App\Models\iVca;

use Illuminate\Database\Eloquent\Model;

class ivcaRole extends Model
{
    protected $fillable = ['name'];

    //For Dynamic Search 
    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }
}
