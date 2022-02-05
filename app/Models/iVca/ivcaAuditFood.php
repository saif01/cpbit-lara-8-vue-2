<?php

namespace App\Models\iVca;

use Illuminate\Database\Eloquent\Model;

class ivcaAuditFood extends Model
{
    // add two column append
    public $appends = [
        'imglgpath', 'imgsmpath'
    ];

    // Image path field added
    public function getImglgpathAttribute()
    {
        return url('/'). '/images/ivca/food/';
    }

    // Image small path field added
    public function getImgsmpathAttribute()
    {
        return url('/').'/images/ivca/food/small/';
    }



    public function vendor(){
        return $this->belongsTo('App\Models\iVCA\ivcaVendorList', 'vendor_id', 'id');
    }

    public function auditordata(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function activetoken(){
        return $this->belongsTo('App\Models\iVCA\ivcaAuditFoodToken', 'token_id', 'id');
    }

    public function schedule(){
        // return $this->hasOne('App\Phone', 'foreign_key', 'local_key');
        return $this->hasOne('App\Models\iVCA\ivcaFoodSchedule', 'id', 'schedule_id');
    }
    
    
}
