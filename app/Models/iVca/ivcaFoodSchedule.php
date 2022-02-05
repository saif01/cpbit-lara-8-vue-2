<?php

namespace App\Models\iVCA;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ivcaFoodSchedule extends Model
{

    public function vendor(){
        return $this->belongsTo('App\Models\iVCA\ivcaVendorList', 'vendor_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function activetoken(){
        return $this->belongsTo('App\Models\iVCA\ivcaAuditFoodToken', 'id', 'schedule_id');
    }


    public function audited_food(){
        return $this->hasOne('App\Models\iVCA\ivcaAuditFood', 'schedule_id', 'id')->where('created_by', Auth::user()->id);
    }



    //For Dynamic Search  
    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('date', 'LIKE', '%'.$val.'%')
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
        })
        ->orWhereHas('user', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        }); 
    }

}

