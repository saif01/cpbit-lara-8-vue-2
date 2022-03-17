<?php

namespace App\Http\Controllers\PBI\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pbi\PbiRole;
use Auth;

class ReportController extends Controller
{
    //report
    public function report(Request $request){
        //dd($request->all(), $request->name);
        $name = $request->name;
       
        // Check Role Have or not
        $check = Auth::user()->pbi_hasRole($name);

       
        if($check){

            $allData = PbiRole::where('name', $name)->select('link', 'name')->first();
            //$link = $rowdata->link;

        }else{
            $allData = '';
        }

        //dd($check, $link);


        return response()->json($allData, 200);
        
    }
}
