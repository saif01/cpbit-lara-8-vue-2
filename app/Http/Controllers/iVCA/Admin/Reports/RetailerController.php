<?php

namespace App\Http\Controllers\iVCA\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use PDF;
use App\Http\Controllers\iVCA\Admin\Reports\CommonFunction;
use App\Models\iVCA\ivcaAuditMroToken;

use App\Models\iVCA\ivcaAuditMroRetailer;
use App\Models\iVca\ivcaTemplateMroRetailer;

class RetailerController extends Controller
{
    use CommonFunction;

    //index 
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ivcaAuditMroToken::with(['vendor', 'audits_retailer.auditordata'])
            ->whereHas('audits_retailer', function($query){
                $query->where( 'status', '1' ); // role with no admin
            })
            ->where('template', 'mro_retailer')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);
               
        //dd($allData);

        return response()->json($allData, 200);

    }

    
    // single_audit_data
    public function single_audit_data($id){

        $templateData = ivcaTemplateMroRetailer::first();
        $auditData = ivcaAuditMroRetailer::with(['auditordata', 'vendor'])->find($id);

        // dd($templateData); 

        if( $auditData->status == 1 ){

           $singleAuditReport = $this->retailerSingleRiport($auditData);

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

        $allData = ivcaAuditMroRetailer::with(['vendor', 'auditordata'])
                    ->where('token', $token)
                    ->where('status', 1)
                    ->orderBy('id')
                    ->get();

        // dd($token, $allData, $allData->isEmpty());

        if( ! $allData->isEmpty() ){

            $finalResult = $this->retailerSummaryReport($allData);

           // dd($finalResult);

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

        $allData = ivcaAuditMroRetailer::with(['vendor', 'auditordata'])
        ->where('token', $token)
        ->where('status', 1)
        ->orderBy('id')
        ->get();
 
        // dd($token, $allData, $allData->isEmpty());
        if( ! $allData->isEmpty() ){
            $finalResult = (object) $this->retailerSummaryReport($allData);
        }
         return view('ivca.admin.pdf.retailer-summary', compact('finalResult'));
        
    }


    // download_summary
    public function download_summary($token){
        //dd($token);

        $allData = ivcaAuditMroRetailer::with(['vendor', 'auditordata'])
        ->where('token', $token)
        ->where('status', 1)
        ->orderBy('id')
        ->get();

        // dd($token, $allData, $allData->isEmpty());

        if( ! $allData->isEmpty() ){
            $finalResult = (object) $this->retailerSummaryReport($allData);
        
        }

        // PDF Generate
        $pdf = PDF::loadView('ivca.admin.pdf.retailer-summary', compact('finalResult'))
        ->setOption('footer-center', 'Page [page] of [toPage]')
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8")
        ->output();

        return $pdf;
    }
 


    //view
    public function view($id){
 
        $templateData = ivcaTemplateMroRetailer::first();
        $auditData = ivcaAuditMroRetailer::with(['auditordata', 'vendor'])->find($id); 

        if( $auditData->status == 1 ){
        $singleAuditReport = $this->retailerSingleRiport($auditData);
            //dd( $singleAuditReport );
        }

        return view('ivca.admin.pdf.retailer', compact('singleAuditReport', 'templateData'));
    }
 

    // download
    public function download($id){
        
        $templateData = ivcaTemplateMroRetailer::first();
        $auditData = ivcaAuditMroRetailer::with(['auditordata', 'vendor'])->find($id); 

        if( $auditData->status == 1 ){
        $singleAuditReport = $this->manufacturerSingleRiport($auditData);
            //dd( $singleAuditReport );
        }

        // PDF Generate
        $pdf = PDF::loadView('ivca.admin.pdf.retailer', compact('singleAuditReport', 'templateData'))
        ->setOption('footer-center', 'Page [page] of [toPage]')
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8")
        ->output();

        return $pdf;
    }

}
