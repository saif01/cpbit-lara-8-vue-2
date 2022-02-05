<?php

namespace App\Http\Controllers\iVCA\User\Mro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaTemplateFood; 
use App\Models\iVca\ivcaTemplateMroImporter;
use App\Models\iVca\ivcaTemplateMroManufacturer;
use App\Models\iVca\ivcaTemplateMroRetailer;

class TemplateController extends Controller
{
    // manufacturer
    public function manufacturer(){

        $allData = ivcaTemplateMroManufacturer::orderBy('id', 'desc')->first();
        return response()->json($allData, 200);
    }

    // importer
    public function importer(){
        $allData = ivcaTemplateMroImporter::orderBy('id', 'desc')->first();
        return response()->json($allData, 200);
    }

    // retailer
    public function retailer(){
        $allData = ivcaTemplateMroRetailer::orderBy('id', 'desc')->first();
        return response()->json($allData, 200);
    }


}
