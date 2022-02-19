<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareCategory extends Model
{
    use HasFactory;

    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    // Accessories
    public function acsosoris()
    {
        //return $this->belongsToMany('App\Models\iService\iservicePowerbi');
        return $this->belongsToMany('App\Models\Cms\Hardware\HardwareAcsosoris', 'hardware_cat_accsosoris', 'acosoris_id', 'cat_id');
    }

    public function subcat()
    {
        return $this->hasMany('App\Models\Cms\Hardware\HardwareSubcategory', 'cat_id', 'id');
    }





    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }
}
