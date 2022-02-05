<?php

namespace App\Http\Controllers\iVCA\User\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaTemplateFood;

class TemplateController extends Controller
{
    //template
    public function template(){
        $allData = ivcaTemplateFood::orderBy('id', 'desc')->first();
        return response()->json($allData, 200);
    }
}
