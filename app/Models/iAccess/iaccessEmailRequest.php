<?php

namespace App\Models\iAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iaccessEmailRequest extends Model
{
    use HasFactory;


    public function emailschedule(){
        return $this->belongsTo('App\Models\Email\ScheduleEmailIaccessEmailReq', 'id', 'email_form_id');
    }
}
