<?php

namespace App\Models\Cms\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationRemarks extends Model
{
    use HasFactory;

    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Cms\Application\ApplicationCategory', 'cat_id', 'id');
    }

    public function mail(){
        //return $this->belongsTo('App\Models\Email\ScheduleEmailCmsHard', 'id', 'rem_id')->select(['id']);
        return $this->hasOne('App\Models\Email\ScheduleEmailCmsApplication', 'rem_id', 'id');
        
    }


    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('name', 'LIKE', '%'.$val.'%'); 
    }
    
}
