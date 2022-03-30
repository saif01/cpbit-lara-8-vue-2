<?php

namespace App\Models\iAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iaccessGuestRequest extends Model
{
    use HasFactory;

    public function emailschedule(){
        return $this->belongsTo('App\Models\Email\ScheduleEmailIaccessGuestReq', 'id', 'guest_form_id');
    }
}
