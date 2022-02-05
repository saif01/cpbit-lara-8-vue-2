<?php

namespace App\Http\Controllers\iVCA\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use DB;
use PDF;
use App\Http\Controllers\iVCA\Admin\Reports\CommonFunction;
use App\Models\iVCA\ivcaAuditMroToken;

use App\Models\iVCA\ivcaAuditMroManufacturer;
use App\Models\iVca\ivcaTemplateMroManufacturer;

class ManufacturerController extends Controller
{
    use CommonFunction;

    //index 
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ivcaAuditMroToken::with(['vendor', 'audits_manufacturer.auditordata'])
                ->whereHas('audits_manufacturer', function($query){
                    $query->where( 'status', '1' ); // role with no admin
                })
                ->where('template', 'mro_manufacturer')
                ->orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);
               
        //dd($allData);

        return response()->json($allData, 200);

    }


    // single_audit_data
    public function single_audit_data($id){

        $templateData = ivcaTemplateMroManufacturer::first();
        $auditData = ivcaAuditMroManufacturer::with(['auditordata', 'vendor'])->find($id);

        // dd($templateData); 

        if( $auditData->status == 1 ){

           $singleAuditReport = $this->manufacturerSingleRiport($auditData);

            //dd( $singleAuditReport );
            return response()->json(['singleAuditReport'=>$singleAuditReport, 'templateData'=>$templateData ], 200);

        }else{
            return response()->json(['No Data Available'], 204);
        }

        // return response()->json(['auditData'=>$auditData, 'templateData'=>$templateData ], 200);

    } 

    


    // summary_audit_data
    public function summary_audit_data(Request $request){
        $token = $request->token;

        $allData = ivcaAuditMroManufacturer::with(['vendor', 'auditordata'])
                    ->where('token', $token)
                    ->where('status', 1)
                    ->orderBy('id')
                    ->get();

        // dd($token, $allData, $allData->isEmpty());

        if( ! $allData->isEmpty() ){

            $finalResult = $this->manufacturerSummaryReport($allData);

            return response()->json($finalResult, 200);

        }else{
            return response()->json(['No Data Available'], 204);
        }
        
    }



    // PDF PDF PDF
    // PDF PDF PDF
    // PDF PDF PDF
    // PDF PDF PDF
    // PDF PDF PDF
    // PDF PDF PDF


    //view_summary
    public function view_summary($token){

        $allData = ivcaAuditMroManufacturer::with(['vendor', 'auditordata'])
        ->where('token', $token)
        ->where('status', 1)
        ->orderBy('id')
        ->get();
 
        // dd($token, $allData, $allData->isEmpty());
        if( ! $allData->isEmpty() ){
            $finalResult = (object) $this->manufacturerSummaryReport($allData);
        }
         return view('ivca.admin.pdf.manufacturer-summary', compact('finalResult'));
        
    }
 


    //view
    public function view($id){
 
        $templateData = ivcaTemplateMroManufacturer::first();
        $auditData = ivcaAuditMroManufacturer::with(['auditordata', 'vendor'])->find($id); 

        if( $auditData->status == 1 ){
        $singleAuditReport = $this->manufacturerSingleRiport($auditData);
            //dd( $singleAuditReport );
        }

        return view('ivca.admin.pdf.manufacturer', compact('singleAuditReport', 'templateData'));
    }
 
 
 
    // download_summary
    public function download_summary($token){
        //dd($token);

        $allData = ivcaAuditMroManufacturer::with(['vendor', 'auditordata'])
        ->where('token', $token)
        ->where('status', 1)
        ->orderBy('id')
        ->get();

        // dd($token, $allData, $allData->isEmpty());

        if( ! $allData->isEmpty() ){
            $finalResult = (object) $this->manufacturerSummaryReport($allData);
        
        }

        // PDF Generate
        $pdf = PDF::loadView('ivca.admin.pdf.manufacturer-summary', compact('finalResult'))
        ->setOption('footer-center', 'Page [page] of [toPage]')
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8")
        ->output();

        return $pdf;
    }
 


    // download
    public function download($id){
        
        $templateData = ivcaTemplateMroManufacturer::first();
        $auditData = ivcaAuditMroManufacturer::with(['auditordata', 'vendor'])->find($id); 

        if( $auditData->status == 1 ){
        $singleAuditReport = $this->manufacturerSingleRiport($auditData);
            //dd( $singleAuditReport );
        }

        // PDF Generate
        $pdf = PDF::loadView('ivca.admin.pdf.manufacturer', compact('singleAuditReport', 'templateData'))
        ->setOption('footer-center', 'Page [page] of [toPage]')
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8")
        ->output();

        return $pdf;
    }

}
