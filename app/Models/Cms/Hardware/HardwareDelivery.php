<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareDelivery extends Model
{
    use HasFactory;

    public function mail(){
        //return $this->belongsTo('App\Models\Email\ScheduleEmailCmsHard', 'id', 'rem_id')->select(['id']);
        return $this->hasOne('App\Models\Email\ScheduleEmailCmsHard', 'delv_id', 'id');
    }
}
