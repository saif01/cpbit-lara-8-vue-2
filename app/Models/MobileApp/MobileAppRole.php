<?php

namespace App\Models\MobileApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileAppRole extends Model
{
    use HasFactory;

    public function makby(){
        // return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }
}
