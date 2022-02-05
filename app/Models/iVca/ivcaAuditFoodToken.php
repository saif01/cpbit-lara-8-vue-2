<?php

namespace App\Models\iVCA;

use Illuminate\Database\Eloquent\Model;

class ivcaAuditFoodToken extends Model
{
    public function vendor(){
        return $this->belongsTo('App\Models\iVCA\ivcaVendorList', 'vendor_id', 'id');
    }

    public function audits(){
        return $this->hasMany('App\Models\iVCA\ivcaAuditFood', 'token', 'token');
    }

    
    //For Dynamic Search 
    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('date', 'LIKE', '%'.$val.'%')
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
        }); 
    } 
}
