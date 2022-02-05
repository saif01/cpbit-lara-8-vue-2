<?php

namespace App\Http\Controllers\iVCA\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use PDF;
use App\Http\Controllers\iVCA\Admin\Reports\CommonFunction;
use App\Models\iVCA\ivcaAuditFoodToken;

use App\Models\iVCA\ivcaAuditFood;
use App\Models\iVca\ivcaTemplateFood;

class FoodController extends Controller
{
    use CommonFunction;

    //index 
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ivcaAuditFoodToken::with(['vendor', 'audits.auditordata'])
            ->whereHas('audits', function($query){
                $query->where( 'status', '1' ); // role with no admin
            })
            ->where('template', 'food')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);
               
           // dd($allData);

        return response()->json($allData, 200);

    }

    
    // food_summery
    public function food_summery($id){

        $templateData = ivcaTemplateFood::first();
        $auditData = ivcaAuditFood::with(['auditordata', 'schedule', 'vendor'])->find($id);

        // dd($templateData); 

         
        //dd( $singleAuditReport );
        return response()->json(['auditData'=>$auditData, 'templateData'=>$templateData ], 200);
    } 

    


    

    
    // PDF PDF PDF
    // PDF PDF PDF
    // PDF PDF PDF
    // PDF PDF PDF
    // PDF PDF PDF
    // PDF PDF PDF



 


    //view
    public function view($id){
 
        $templateData = ivcaTemplateFood::first();
        $auditData = ivcaAuditFood::with(['auditordata', 'schedule', 'vendor'])->find($id);

        return view('ivca.admin.pdf.food', compact('auditData', 'templateData'));
    }
 

    // download
    public function download($id){
        
        $templateData = ivcaTemplateFood::first();
        $auditData = ivcaAuditFood::with(['auditordata', 'schedule', 'vendor'])->find($id);

       
        // PDF Generate
        $pdf = PDF::loadView('ivca.admin.pdf.food', compact('auditData', 'templateData'))
        //->setOption('footer-center', 'Page [page] of [toPage]')
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8")
        ->output();

        return $pdf;
    }

}
