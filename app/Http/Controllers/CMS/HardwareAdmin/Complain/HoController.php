<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\SuperAdmin\ZoneOffice;
use App\Models\SuperAdmin\Zone;
use Auth;
use App\Models\User;
use App\Models\Cms\Hardware\HardwareHORemark;
use App\Models\Cms\Hardware\HardwareDamaged;

use App\Http\Controllers\Common\ImageUpload;
use App\Http\Controllers\CMS\HardwareAdmin\CommonController;
use App\Http\Controllers\Common\Email\ScheduleEmailCmsHardware;


class HoController extends Controller
{
    use ImageUpload;

    //index
    public function index(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess ); 

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $selected_zone  = Request('selected_zone', 'All');



        $allDataQuery = HardwareComplain::with('makby', 'category', 'subcategory');

        if($selected_zone == 'All'){

            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            });

        }else{

            // Check access offices
            $accessZoneOfficesQuery = ZoneOffice::where('name', $selected_zone)->select('offices')->first();
           
            if(!empty($accessZoneOfficesQuery)){
                $offices = $accessZoneOfficesQuery->offices;
                // string to array
                $accessZoneOffices = explode(',', $offices);
            }else{
                $accessZoneOffices = [];
            }
           

            //dd($selected_zone,  $accessZoneOffices,  $accessZoneOfficesQuery);
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            }); 

        }
           


          $allData = $allDataQuery->where('process', 'HO Service')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    }  


    // zone_data
    public function zone_data(){
        // $allData = User::with('zons')->find(Auth::user()->id);
        // $allData = $allData->zons()->select('name')->get()->toArray();

        $allData = Zone::where('name', '!=', 'Dhaka')->where('status', 1)->select('name')->get();
      
        // Custom Field Data Add
        $custom = collect( [['name' => 'All']] );
        $allData = $custom->merge($allData);

        //dd($allData);

        return response()->json($allData, 200);
    }


    // action_remarks
    public function action_remarks(Request $request){

        // dd($request->all());
        //Validate
        $this->validate($request,[
            'comp_id'   => 'required',
            'process'   => 'required',
            'details'   => 'required|min:10|max:20000',
        ]);

        $comp_id = $request->comp_id;
        $process = $request->process;

        $remarks_data = new HardwareHORemark();

       
        $documentPath = 'images/hardware/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name = $this->documentUpload($document, $documentPath);
            $remarks_data->document     = $document_full_name;
        }

        $remarks_data->comp_id      = $comp_id;
        $remarks_data->process      = $process;
        $remarks_data->details      = $request->details;
        $remarks_data->created_by   = Auth::user()->id;
       
        $success = $remarks_data->save();
       

        // Main Complain tbl data update 
        if($process == 'Damaged' || $process == 'Partial Damaged' || $process == 'Closed'){

            $complain_data           = HardwareComplain::find($comp_id);
            $complain_data->process  = $process;
            $complain_data->save();

            // For email
            ScheduleEmailCmsHardware::STORE_DAMAGED_HO($complain_data, $remarks_data);
        }



        // Damageded or partial damaged data update
        if($process == 'Damaged' || $process == 'Partial Damaged'){

            $damaged_data  = new HardwareDamaged();
            $damaged_data->comp_id         = $comp_id;
            $damaged_data->damaged_reason  = $request->damaged_reason;
            $damaged_data->applicable_type = $request->applicable_type;
            $damaged_data->created_by      = Auth::user()->id;
            $damaged_data->save();

        }


        

        if($success){
            return response()->json(['msg'=>'Submited Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    // action_remarks_data
    public function action_remarks_data($id){
        $allData = HardwareHORemark::where('comp_id', $id)
            ->orderBy('id', 'desc')
            ->select('process')
            ->first();

        return response()->json($allData, 200);
    }



}
