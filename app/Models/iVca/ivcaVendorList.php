<?php

namespace App\Models\iVca;

use Illuminate\Database\Eloquent\Model;

class ivcaVendorList extends Model
{
    
    //For Dynamic Search 
    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('vendor_number', 'LIKE', '%'.$val.'%')
        ->Orwhere('suppier_name', 'LIKE', '%'.$val.'%')
        ->Orwhere('address', 'LIKE', '%'.$val.'%')
        ->Orwhere('contact_name', 'LIKE', '%'.$val.'%')
        ->Orwhere('telephone', 'LIKE', '%'.$val.'%')
        ->Orwhere('email', 'LIKE', '%'.$val.'%'); 
    }
}
