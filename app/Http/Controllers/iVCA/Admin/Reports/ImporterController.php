<?php

namespace App\Http\Controllers\iVCA\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use PDF;
use App\Http\Controllers\iVCA\Admin\Reports\CommonFunction;
use App\Models\iVCA\ivcaAuditMroToken;

use App\Models\iVCA\ivcaAuditMroImporter;
use App\Models\iVca\ivcaTemplateMroImporter;
use App\Exports\ivca\summuryImporter;

use App\Exports\ivca\singleImporter;
use Maatwebsite\Excel\Facades\Excel;

class ImporterController extends Controller
{
    use CommonFunction;

    //index 
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ivcaAuditMroToken::with(['vendor', 'audits_importer.auditordata'])
            ->whereHas('audits_importer', function($query){
                $query->where( 'status', '1' ); // role with no admin
            })
            ->where('template', 'mro_importer')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);
               
        //dd($allData);

        return response()->json($allData, 200);

    }

    
    // single_audit_data
    public function single_audit_data($id){

        $templateData = ivcaTemplateMroImporter::first();
        $auditData = ivcaAuditMroImporter::with(['auditordata', 'vendor'])->find($id);

        // dd($templateData); 

        if( $auditData->status == 1 ){

           $singleAuditReport = $this->importerSingleRiport($auditData);

            //dd( $singleAuditReport );
            return response()->json(['singleAuditReport'=>$singleAuditReport, 'templateData'=>$templateData ], 200);

        }else{
            return response()->json(['No Data Available'], 204);
        }

        // return response()->json(['auditData'=>$auditData, 'templateData'=>$templateData ], 200);

    } 

    // export_single_audit_data
    public function export_single_audit_data($id){

        $templateData = ivcaTemplateMroImporter::first();
        $auditData = ivcaAuditMroImporter::with(['auditordata', 'vendor'])->find($id);

        // dd($templateData); 

        if( $auditData->status == 1 ){

           $singleAuditReport = $this->importerSingleRiport($auditData);

            return Excel::download(new singleImporter($singleAuditReport, $templateData), 'product-' . time() . '.xlsx');

        }else{
            return response()->json(['No Data Available'], 204);
        }

    }

    


    // summary_audit_data
    public function summary_audit_data(Request $request){
        $token = $request->token;

        $allData = ivcaAuditMroImporter::with(['vendor', 'auditordata'])
                    ->where('token', $token)
                    ->where('status', 1)
                    ->orderBy('id')
                    ->get();

        // dd($token, $allData, $allData->isEmpty());

        if( ! $allData->isEmpty() ){

            $finalResult = $this->importerSummaryReport($allData);

           // dd($finalResult);

            return response()->json($finalResult, 200);

        }else{
            return response()->json(['No Data Available'], 204);
        }
        
    }


    public function export_summary_audit_data(Request $request){
        $token = $request->token;

        $allData = ivcaAuditMroImporter::with(['vendor', 'auditordata'])
                    ->where('token', $token)
                    ->where('status', 1)
                    ->orderBy('id')
                    ->get();

        // dd($token, $allData, $allData->isEmpty());

        if( ! $allData->isEmpty() ){

            $finalResult = $this->importerSummaryReport($allData);

            return Excel::download(new summuryImporter($finalResult), 'product-' . time() . '.xlsx');

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

        $allData = ivcaAuditMroImporter::with(['vendor', 'auditordata'])
        ->where('token', $token)
        ->where('status', 1)
        ->orderBy('id')
        ->get();
 
        // dd($token, $allData, $allData->isEmpty());
        if( ! $allData->isEmpty() ){
            $finalResult = (object) $this->importerSummaryReport($allData);
        }
         return view('ivca.admin.pdf.importer-summary', compact('finalResult'));
        
    }


    // download_summary
    public function download_summary($token){
        //dd($token);

        $allData = ivcaAuditMroImporter::with(['vendor', 'auditordata'])
        ->where('token', $token)
        ->where('status', 1)
        ->orderBy('id')
        ->get();

        // dd($token, $allData, $allData->isEmpty());

        if( ! $allData->isEmpty() ){
            $finalResult = (object) $this->importerSummaryReport($allData);
        
        }

        // PDF Generate
        $pdf = PDF::loadView('ivca.admin.pdf.importer-summary', compact('finalResult'))
        ->setOption('footer-center', 'Page [page] of [toPage]')
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8")
        ->output();

        return $pdf;
    }
 


    //view
    public function view($id){
 
        $templateData = ivcaTemplateMroImporter::first();
        $auditData = ivcaAuditMroImporter::with(['auditordata', 'vendor'])->find($id); 

        if( $auditData->status == 1 ){
        $singleAuditReport = $this->importerSingleRiport($auditData);
            //dd( $singleAuditReport );
        }

        return view('ivca.admin.pdf.importer', compact('singleAuditReport', 'templateData'));
    }
 

    // download
    public function download($id){
        
        $templateData = ivcaTemplateMroImporter::first();
        $auditData = ivcaAuditMroImporter::with(['auditordata', 'vendor'])->find($id); 

        if( $auditData->status == 1 ){
            $singleAuditReport = $this->importerSingleRiport($auditData);
        }

        // PDF Generate
        $pdf = PDF::loadView('ivca.admin.pdf.importer', compact('singleAuditReport', 'templateData'))
        ->setOption('footer-center', 'Page [page] of [toPage]')
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8")
        ->output();

        return $pdf;
    }

}

