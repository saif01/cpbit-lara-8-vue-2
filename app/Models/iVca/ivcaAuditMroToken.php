<?php

namespace App\Models\iVCA;

use Illuminate\Database\Eloquent\Model;

class ivcaAuditMroToken extends Model
{
    public function vendor(){
        return $this->belongsTo('App\Models\iVCA\ivcaVendorList', 'vendor_id', 'id');
    }

  
    public function audits(){
        // return $this->belongsTo('App\Models\iVCA\ivcaAuditMroManufacturer', 'token', 'token');
        // return $this->hasMany(Comment::class, 'foreign_key', 'local_key');

        return $this->hasMany('App\Models\iVCA\ivcaAuditMroManufacturer', 'token', 'token');
    }

    public function audits_manufacturer(){
        return $this->hasMany('App\Models\iVCA\ivcaAuditMroManufacturer', 'token', 'token');
    }

    public function audits_importer(){
        return $this->hasMany('App\Models\iVCA\ivcaAuditMroImporter', 'token', 'token');
    }

    public function audits_retailer(){
        return $this->hasMany('App\Models\iVCA\ivcaAuditMroRetailer', 'token', 'token');
    }

    
    public function schedule(){
        return $this->hasOne('App\Models\iVCA\ivcaMroSchedule', 'id', 'schedule_id');
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
