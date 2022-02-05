<?php

namespace App\Models\iVCA;

use Illuminate\Database\Eloquent\Model;

use Auth;

class ivcaMroSchedule extends Model
{

    public function vendor(){
        return $this->belongsTo('App\Models\iVCA\ivcaVendorList', 'vendor_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function activetoken(){
        return $this->belongsTo('App\Models\iVCA\ivcaAuditMroToken', 'id', 'schedule_id');
    }

    public function audited_manufacturer(){
        return $this->hasOne('App\Models\iVCA\ivcaAuditMroManufacturer', 'schedule_id', 'id')->where('created_by', Auth::user()->id);
    }

    public function audited_importer(){
        return $this->hasOne('App\Models\iVCA\ivcaAuditMroImporter', 'schedule_id', 'id')->where('created_by', Auth::user()->id);
    }

    public function audited_retailer(){
        return $this->hasOne('App\Models\iVCA\ivcaAuditMroRetailer', 'schedule_id', 'id')->where('created_by', Auth::user()->id);
    }


    // public function check(){
    //     return $this->hasOne('App\Models\iVCA\ivcaAuditMroManufacturer','schedule_id', 'id')->where('created_by', Auth::user()->id);
    // }

    



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
