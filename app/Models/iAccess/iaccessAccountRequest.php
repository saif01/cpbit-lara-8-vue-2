<?php

namespace App\Models\iAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iaccessAccountRequest extends Model
{
    use HasFactory;

    public function emailschedule(){
        return $this->belongsTo('App\Models\Email\ScheduleEmailIaccessAccountReq', 'id', 'account_form_id');
    }
}
