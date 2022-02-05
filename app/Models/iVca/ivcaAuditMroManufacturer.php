<?php

namespace App\Models\iVca;

use Illuminate\Database\Eloquent\Model;

class ivcaAuditMroManufacturer extends Model
{


    // add two column append
    public $appends = [
        'imglgpath', 'imgsmpath'
    ];

    // Image path field added
    public function getImglgpathAttribute()
    {
        return url('/'). '/images/ivca/';
    }

    // Image small path field added
    public function getImgsmpathAttribute()
    {
        return url('/').'/images/ivca/small/';
    }



    public function vendor(){
        return $this->belongsTo('App\Models\iVCA\ivcaVendorList', 'vendor_id', 'id');
    }

    public function auditordata(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function activetoken(){
        return $this->belongsTo('App\Models\iVCA\ivcaAuditMroToken', 'token_id', 'id');
    }


    
    // //For Dynamic Search 
    // public function scopeSearch($query, $val='')
    // {
    //     return $query
    //     ->where('date', 'LIKE', '%'.$val.'%')
    //     ->Orwhere('remarks', 'LIKE', '%'.$val.'%')
    //     ->orWhereHas('vendor', function($query) use ($val){
    //         $query->WhereRaw('vendor_number LIKE ?', '%'.$val.'%');
    //     })
    //     ->orWhereHas('vendor', function($query) use ($val){
    //         $query->WhereRaw('suppier_name LIKE ?', '%'.$val.'%');
    //     })
    //     ->orWhereHas('vendor', function($query) use ($val){
    //         $query->WhereRaw('address LIKE ?', '%'.$val.'%');
    //     })
    //     ->orWhereHas('vendor', function($query) use ($val){
    //         $query->WhereRaw('contact_name LIKE ?', '%'.$val.'%');
    //     })
    //     ->orWhereHas('vendor', function($query) use ($val){
    //         $query->WhereRaw('telephone LIKE ?', '%'.$val.'%');
    //     })
    //     ->orWhereHas('vendor', function($query) use ($val){
    //         $query->WhereRaw('email LIKE ?', '%'.$val.'%');
    //     })
    //     ->orWhereHas('user', function($query) use ($val){
    //         $query->WhereRaw('name LIKE ?', '%'.$val.'%');
    //     }); 
    // } 
}
