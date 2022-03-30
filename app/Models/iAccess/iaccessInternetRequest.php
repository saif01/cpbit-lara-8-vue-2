<?php

namespace App\Models\iAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iaccessInternetRequest extends Model
{
    use HasFactory;

    public function emailschedule(){
        return $this->belongsTo('App\Models\Email\ScheduleEmailIaccessInternetReq', 'id', 'internet_form_id');
    }
}
