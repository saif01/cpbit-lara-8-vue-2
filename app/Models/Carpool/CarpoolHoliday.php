<?php

namespace App\Models\Carpool;

use Illuminate\Database\Eloquent\Model;

class CarpoolHoliday extends Model
{
    protected $fillable = [
        'title', 'start', 'end', 'remarks', 'status', 'create_by'
    ];
}
