<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareHORemark extends Model
{
    use HasFactory;

    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
 
    public function category(){
        return $this->belongsTo('App\Models\Cms\Hardware\HardwareCategory', 'cat_id', 'id');
    }

    public function mail(){
        return $this->hasOne('App\Models\Email\ScheduleEmailCmsHardware', 'ho_rem_id', 'id'); 
    }

    public function dam_apply(){
        return $this->hasOne('App\Models\Cms\Hardware\HardwareDamaged', 'comp_id', 'comp_id');
    }


    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }
}
