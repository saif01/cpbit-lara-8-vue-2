<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryOldProduct extends Model
{
    use HasFactory;


    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function newtbldata()
    {
        return $this->belongsTo('App\Models\Inventory\InventoryNewProduct', 'new_pro_id', 'id');
    }


    public function category(){
        return $this->belongsTo('App\Models\Cms\Hardware\HardwareCategory', 'cat_id', 'id');
    }

    public function subcategory(){
        return $this->belongsTo('App\Models\Cms\Hardware\HardwareSubcategory', 'subcat_id', 'id');
    }

    public function business(){
        return $this->belongsTo('App\Models\User', 'business_unit_id', 'id');
    }

    public function operation(){
        return $this->belongsTo('App\Models\Inventory\InventoryOperation', 'operation_id', 'id');
    }

    public function office(){
        return $this->belongsTo('App\Models\User', 'office_id', 'id');
    }

    public function complain(){
        return $this->belongsTo('App\Models\Cms\Hardware\HardwareComplain', 'comp_id', 'id');
    }


    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('serial', 'LIKE', '%'.$val.'%')
        ->where('name', 'LIKE', '%'.$val.'%')
        ->where('remarks', 'LIKE', '%'.$val.'%')
        ->orWhereHas('makby', function($query) use ($val){
            $query->WhereRaw('login LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('category', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('subcategory', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        }); 
    }

}
