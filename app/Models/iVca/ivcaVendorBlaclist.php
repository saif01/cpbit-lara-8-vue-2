<?php

namespace App\Models\iVCA;

use Illuminate\Database\Eloquent\Model;

class ivcaVendorBlaclist extends Model
{

    public function vendor(){
        return $this->belongsTo('App\Models\iVCA\ivcaVendorList', 'vendor_id', 'id');
    }
    

    //For Dynamic Search 
    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('start', 'LIKE', '%'.$val.'%')
        ->Orwhere('end', 'LIKE', '%'.$val.'%')
        ->Orwhere('remarks', 'LIKE', '%'.$val.'%')
        ->orWhereHas('vendor', function($query) use ($val){
            $query->WhereRaw('vendor_number LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('vendor', function($query) use ($val){
            $query->WhereRaw('suppier_name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('vendor', function($query) use ($val){
            $query->WhereRaw('address LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('vendor', function($query) use ($val){
            $query->WhereRaw('contact_name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('vendor', function($query) use ($val){
            $query->WhereRaw('telephone LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('vendor', function($query) use ($val){
            $query->WhereRaw('email LIKE ?', '%'.$val.'%');
        }); 
    }
}
