<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareDelivery extends Model
{
    use HasFactory;

    public function mail(){
        //return $this->belongsTo('App\Models\Email\ScheduleEmailCmsHard', 'id', 'rem_id')->select(['id']);
        return $this->hasOne('App\Models\Email\ScheduleEmailCmsHardware', 'deliver_id', 'id');
    }

    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function complain(){
        return $this->hasOne('App\Models\Cms\Hardware\HardwareComplain', 'id', 'comp_id');
    }

    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('rec_name', 'LIKE', '%'.$val.'%')
        ->orWhere('rec_contact', 'LIKE', '%'.$val.'%')
        ->orWhere('rec_position', 'LIKE', '%'.$val.'%')
        ->orWhere('details', 'LIKE', '%'.$val.'%')
        ->orWhereHas('makby', function($query) use ($val){
            $query->WhereRaw('login LIKE ?', '%'.$val.'%');
        })
        // ->orWhereHas('complain.makby', function($query) use ($val){
        //     $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        //     $query->WhereRaw('department LIKE ?', '%'.$val.'%');
        // })
        ->orWhereHas('complain', function($query) use ($val){
            $query->WhereRaw('id LIKE ?', '%'.$val.'%');
        });
        // ->orWhereHas('complain,subcategory', function($query) use ($val){
        //     $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        // })
        // ->orWhereHas('complain.category', function($query) use ($val){
        //     $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        // }); 
    }
}
