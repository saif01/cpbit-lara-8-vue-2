<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareComplain extends Model
{
    use HasFactory; 

    public function makby(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Cms\Hardware\HardwareCategory', 'cat_id', 'id');
    }

    public function subcategory(){
        return $this->belongsTo('App\Models\Cms\Hardware\HardwareSubcategory', 'subcat_id', 'id');
    }

    public function remarks(){
        return $this->hasMany('App\Models\Cms\Hardware\HardwareRemarks', 'comp_id', 'id');
    }



    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('id', 'LIKE', '%'.$val.'%')
        ->where('details', 'LIKE', '%'.$val.'%')
        ->orWhereHas('makby', function($query) use ($val){
            $query->WhereRaw('login LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('makby', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('makby', function($query) use ($val){
            $query->WhereRaw('department LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('category', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('subcategory', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        }); 
    }

}
