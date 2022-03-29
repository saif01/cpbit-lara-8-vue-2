<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareCategoryDependence extends Model
{
    use HasFactory;


    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Cms\Hardware\HardwareCategory', 'cat_id', 'id');
    }

    public function dependent(){
        return $this->hasMany('App\Models\Cms\Hardware\HardwareDependency', 'id', 'dep_id');
    }




    public function scopeSearch($query, $val='')
    {
        return $query
        ->WhereHas('dependent', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        });
    }

}
