<?php

namespace App\Models\iVca;

use Illuminate\Database\Eloquent\Model;

class ivcaAuditMroRetailer extends Model
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
}
