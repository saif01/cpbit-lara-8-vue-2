<?php

namespace App\Http\Controllers\iVCA\User\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use Image;
use File;
use Illuminate\Support\Str;
use App\Models\iVca\ivcaTemplateFood;
use App\Models\iVca\ivcaAuditFoodToken;
use App\Models\iVca\ivcaAuditFood;

use App\Http\Controllers\iVCA\User\Common\CommonFunctions;

class AuditController extends Controller
{
    use CommonFunctions;

    // data
    public function data($token){

        $today = date('Y-m-d');
        $user_id = Auth::user()->id;
       
        // Audit Data
        $data = ivcaAuditFood::where('token', $token)
            ->where('created_by', $user_id)
            ->where('date', $today)
            ->first();

        //dd($token, $data);
        return response()->json($data, 200);


    }



    //1 building_facilities_store
    public function building_facilities_store(Request $request, $token){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'building_facilities_a'         => 'required',
            'building_facilities_a_remarks' => 'nullable|string|max:1000',
            'building_facilities_b'         => 'required',
            'building_facilities_b_remarks' => 'nullable|string|max:1000',
            'building_facilities_c'         => 'required',
            'building_facilities_c_remarks' => 'nullable|string|max:1000',
            'building_facilities_d'         => 'required',
            'building_facilities_d_remarks' => 'nullable|string|max:1000',
            'building_facilities_e'         => 'required',
            'building_facilities_e_remarks' => 'nullable|string|max:1000',

        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token);

        //dd($data);
        $data->building_facilities_a            = $request->building_facilities_a;
        $data->building_facilities_a_remarks    = $request->building_facilities_a_remarks;
        $data->building_facilities_b            = $request->building_facilities_b;
        $data->building_facilities_b_remarks    = $request->building_facilities_b_remarks;
        $data->building_facilities_c            = $request->building_facilities_c;
        $data->building_facilities_c_remarks    = $request->building_facilities_c_remarks;
        $data->building_facilities_d            = $request->building_facilities_d;
        $data->building_facilities_d_remarks    = $request->building_facilities_d_remarks;
        $data->building_facilities_e            = $request->building_facilities_e;
        $data->building_facilities_e_remarks    = $request->building_facilities_e_remarks;
        $data->building_facilities_status       = 1;


        $imagePath = 'images/ivca/food/';
        $building_facilities_a_image = $request->building_facilities_a_image; 
        $building_facilities_a_old_image = $data->building_facilities_a_image;
        // Save Image a
        if($building_facilities_a_image != $building_facilities_a_old_image){
            $imgName= $this->imageUplaodByName($building_facilities_a_image, $building_facilities_a_old_image, $imagePath); 
            $data->building_facilities_a_image = $imgName;
        }

        $building_facilities_b_image = $request->building_facilities_b_image; 
        $building_facilities_b_old_image = $data->building_facilities_b_image;
        // Save Image b
        if($building_facilities_b_image != $building_facilities_b_old_image){
            $imgName= $this->imageUplaodByName($building_facilities_b_image, $building_facilities_b_old_image, $imagePath); 
            $data->building_facilities_b_image = $imgName;
        }

        $building_facilities_c_image = $request->building_facilities_c_image; 
        $building_facilities_c_old_image = $data->building_facilities_c_image;
        // Save Image c
        if($building_facilities_c_image != $building_facilities_c_old_image){
            $imgName= $this->imageUplaodByName($building_facilities_c_image, $building_facilities_c_old_image, $imagePath); 
            $data->building_facilities_c_image = $imgName;
        }

        $building_facilities_d_image = $request->building_facilities_d_image; 
        $building_facilities_d_old_image = $data->building_facilities_d_image;
        // Save Image d
        if($building_facilities_d_image != $building_facilities_d_old_image){
            $imgName= $this->imageUplaodByName($building_facilities_d_image, $building_facilities_d_old_image, $imagePath); 
            $data->building_facilities_d_image = $imgName;
        }

        $building_facilities_e_image = $request->building_facilities_e_image; 
        $building_facilities_e_old_image = $data->building_facilities_e_image;
        // Save Image e
        if($building_facilities_e_image != $building_facilities_e_old_image){
            $imgName= $this->imageUplaodByName($building_facilities_e_image, $building_facilities_e_old_image, $imagePath); 
            $data->building_facilities_e_image = $imgName;
        }
        

        $data->save();

        return response()->json([ 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    //2 equipment_store
    public function equipment_store(Request $request, $token){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'equipment_a'         => 'required',
            'equipment_a_remarks' => 'nullable|string|max:1000',
            'equipment_b'         => 'required',
            'equipment_b_remarks' => 'nullable|string|max:1000',
            'equipment_c'         => 'required',
        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token);

        //dd($data);
        $data->equipment_a            = $request->equipment_a;
        $data->equipment_a_remarks    = $request->equipment_a_remarks;
        $data->equipment_b            = $request->equipment_b;
        $data->equipment_b_remarks    = $request->equipment_b_remarks;
        $data->equipment_c            = $request->equipment_c;
        $data->equipment_c_remarks    = $request->equipment_c_remarks;
        $data->equipment_status       = 1;


        $imagePath = 'images/ivca/food/';
        $equipment_a_image = $request->equipment_a_image; 
        $equipment_a_old_image = $data->equipment_a_image;
        // Save Image a
        if($equipment_a_image != $equipment_a_old_image){
            $imgName= $this->imageUplaodByName($equipment_a_image, $equipment_a_old_image, $imagePath); 
            $data->equipment_a_image = $imgName;
        }

        $equipment_b_image = $request->equipment_b_image; 
        $equipment_b_old_image = $data->equipment_b_image;
        // Save Image b
        if($equipment_b_image != $equipment_b_old_image){
            $imgName= $this->imageUplaodByName($equipment_b_image, $equipment_b_old_image, $imagePath); 
            $data->equipment_b_image = $imgName;
        }

        $equipment_c_image = $request->equipment_c_image; 
        $equipment_c_old_image = $data->equipment_c_image;
        // Save Image c
        if($equipment_c_image != $equipment_c_old_image){
            $imgName= $this->imageUplaodByName($equipment_c_image, $equipment_c_old_image, $imagePath); 
            $data->equipment_c_image = $imgName;
        }


        $data->save();

        return response()->json([ 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    //3 personnel_store
    public function personnel_store(Request $request, $token){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'personnel_a'         => 'required',
            'personnel_a_remarks' => 'nullable|string|max:1000',
            'personnel_b'         => 'required',
            'personnel_b_remarks' => 'nullable|string|max:1000',
            'personnel_c'         => 'required',
        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token);

        //dd($data);
        $data->personnel_a            = $request->personnel_a;
        $data->personnel_a_remarks    = $request->personnel_a_remarks;
        $data->personnel_b            = $request->personnel_b;
        $data->personnel_b_remarks    = $request->personnel_b_remarks;
        $data->personnel_c            = $request->personnel_c;
        $data->personnel_c_remarks    = $request->personnel_c_remarks;
        $data->personnel_status       = 1;


        $imagePath = 'images/ivca/food/';
        $personnel_a_image = $request->personnel_a_image; 
        $personnel_a_old_image = $data->personnel_a_image;
        // Save Image a
        if($personnel_a_image != $personnel_a_old_image){
            $imgName= $this->imageUplaodByName($personnel_a_image, $personnel_a_old_image, $imagePath); 
            $data->personnel_a_image = $imgName;
        }

        $personnel_b_image = $request->personnel_b_image; 
        $personnel_b_old_image = $data->personnel_b_image;
        // Save Image b
        if($personnel_b_image != $personnel_b_old_image){
            $imgName= $this->imageUplaodByName($personnel_b_image, $personnel_b_old_image, $imagePath); 
            $data->personnel_b_image = $imgName;
        }

        $personnel_c_image = $request->personnel_c_image; 
        $personnel_c_old_image = $data->personnel_c_image;
        // Save Image c
        if($personnel_c_image != $personnel_c_old_image){
            $imgName= $this->imageUplaodByName($personnel_c_image, $personnel_c_old_image, $imagePath); 
            $data->personnel_c_image = $imgName;
        }


        $data->save();

        return response()->json([ 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    //4 raw_materials_store
    public function raw_materials_store(Request $request, $token){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'raw_materials_a'         => 'required',
            'raw_materials_a_remarks' => 'nullable|string|max:1000',
            'raw_materials_b'         => 'required',
            'raw_materials_b_remarks' => 'nullable|string|max:1000',
            'raw_materials_c'         => 'required',
            'raw_materials_c_remarks' => 'nullable|string|max:1000',
            'raw_materials_d'         => 'required',
            'raw_materials_d_remarks' => 'nullable|string|max:1000',
            'raw_materials_e'         => 'required',
            'raw_materials_e_remarks' => 'nullable|string|max:1000',

        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token);

        //dd($data);
        $data->raw_materials_a            = $request->raw_materials_a;
        $data->raw_materials_a_remarks    = $request->raw_materials_a_remarks;
        $data->raw_materials_b            = $request->raw_materials_b;
        $data->raw_materials_b_remarks    = $request->raw_materials_b_remarks;
        $data->raw_materials_c            = $request->raw_materials_c;
        $data->raw_materials_c_remarks    = $request->raw_materials_c_remarks;
        $data->raw_materials_d            = $request->raw_materials_d;
        $data->raw_materials_d_remarks    = $request->raw_materials_d_remarks;
        $data->raw_materials_e            = $request->raw_materials_e;
        $data->raw_materials_e_remarks    = $request->raw_materials_e_remarks;
        $data->raw_materials_status       = 1;


        $imagePath = 'images/ivca/food/';
        $raw_materials_a_image = $request->raw_materials_a_image; 
        $raw_materials_a_old_image = $data->raw_materials_a_image;
        // Save Image a
        if($raw_materials_a_image != $raw_materials_a_old_image){
            $imgName= $this->imageUplaodByName($raw_materials_a_image, $raw_materials_a_old_image, $imagePath); 
            $data->raw_materials_a_image = $imgName;
        }

        $raw_materials_b_image = $request->raw_materials_b_image; 
        $raw_materials_b_old_image = $data->raw_materials_b_image;
        // Save Image b
        if($raw_materials_b_image != $raw_materials_b_old_image){
            $imgName= $this->imageUplaodByName($raw_materials_b_image, $raw_materials_b_old_image, $imagePath); 
            $data->raw_materials_b_image = $imgName;
        }

        $raw_materials_c_image = $request->raw_materials_c_image; 
        $raw_materials_c_old_image = $data->raw_materials_c_image;
        // Save Image c
        if($raw_materials_c_image != $raw_materials_c_old_image){
            $imgName= $this->imageUplaodByName($raw_materials_c_image, $raw_materials_c_old_image, $imagePath); 
            $data->raw_materials_c_image = $imgName;
        }

        $raw_materials_d_image = $request->raw_materials_d_image; 
        $raw_materials_d_old_image = $data->raw_materials_d_image;
        // Save Image d
        if($raw_materials_d_image != $raw_materials_d_old_image){
            $imgName= $this->imageUplaodByName($raw_materials_d_image, $raw_materials_d_old_image, $imagePath); 
            $data->raw_materials_d_image = $imgName;
        }

        $raw_materials_e_image = $request->raw_materials_e_image; 
        $raw_materials_e_old_image = $data->raw_materials_e_image;
        // Save Image e
        if($raw_materials_e_image != $raw_materials_e_old_image){
            $imgName= $this->imageUplaodByName($raw_materials_e_image, $raw_materials_e_old_image, $imagePath); 
            $data->raw_materials_e_image = $imgName;
        }
        

        $data->save();

        return response()->json([ 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    //5 production_store 
    public function production_store(Request $request, $token){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'production_a'         => 'required',
            'production_a_remarks' => 'nullable|string|max:1000',
            'production_b'         => 'required',
            'production_b_remarks' => 'nullable|string|max:1000',
            'production_c'         => 'required',
            'production_c_remarks' => 'nullable|string|max:1000',
            'production_d'         => 'required',
            'production_d_remarks' => 'nullable|string|max:1000',
            'production_e'         => 'required',
            'production_e_remarks' => 'nullable|string|max:1000',
            'production_f'         => 'required',
            'production_f_remarks' => 'nullable|string|max:1000',

        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token);

        //dd($data);
        $data->production_a            = $request->production_a;
        $data->production_a_remarks    = $request->production_a_remarks;
        $data->production_b            = $request->production_b;
        $data->production_b_remarks    = $request->production_b_remarks;
        $data->production_c            = $request->production_c;
        $data->production_c_remarks    = $request->production_c_remarks;
        $data->production_d            = $request->production_d;
        $data->production_d_remarks    = $request->production_d_remarks;
        $data->production_e            = $request->production_e;
        $data->production_e_remarks    = $request->production_e_remarks;
        $data->production_f            = $request->production_f;
        $data->production_f_remarks    = $request->production_f_remarks;
        $data->production_status       = 1;


        $imagePath = 'images/ivca/food/';
        $production_a_image = $request->production_a_image; 
        $production_a_old_image = $data->production_a_image;
        // Save Image a
        if($production_a_image != $production_a_old_image){
            $imgName= $this->imageUplaodByName($production_a_image, $production_a_old_image, $imagePath); 
            $data->production_a_image = $imgName;
        }

        $production_b_image = $request->production_b_image; 
        $production_b_old_image = $data->production_b_image;
        // Save Image b
        if($production_b_image != $production_b_old_image){
            $imgName= $this->imageUplaodByName($production_b_image, $production_b_old_image, $imagePath); 
            $data->production_b_image = $imgName;
        }

        $production_c_image = $request->production_c_image; 
        $production_c_old_image = $data->production_c_image;
        // Save Image c
        if($production_c_image != $production_c_old_image){
            $imgName= $this->imageUplaodByName($production_c_image, $production_c_old_image, $imagePath); 
            $data->production_c_image = $imgName;
        }

        $production_d_image = $request->production_d_image; 
        $production_d_old_image = $data->production_d_image;
        // Save Image d
        if($production_d_image != $production_d_old_image){
            $imgName= $this->imageUplaodByName($production_d_image, $production_d_old_image, $imagePath); 
            $data->production_d_image = $imgName;
        }

        $production_e_image = $request->production_e_image; 
        $production_e_old_image = $data->production_e_image;
        // Save Image e
        if($production_e_image != $production_e_old_image){
            $imgName= $this->imageUplaodByName($production_e_image, $production_e_old_image, $imagePath); 
            $data->production_e_image = $imgName;
        }

        $production_f_image = $request->production_f_image; 
        $production_f_old_image = $data->production_f_image;
        // Save Image e
        if($production_f_image != $production_f_old_image){
            $imgName= $this->imageUplaodByName($production_f_image, $production_f_old_image, $imagePath); 
            $data->production_f_image = $imgName;
        }
        

        $data->save();

        return response()->json([ 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    //6 records_store
    public function records_store(Request $request, $token){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'records_a'         => 'required',
            'records_a_remarks' => 'nullable|string|max:1000',
            'records_b'         => 'required',
            'records_b_remarks' => 'nullable|string|max:1000',
            'records_c'         => 'required',
            'records_c_remarks' => 'nullable|string|max:1000',
            'records_d'         => 'required',
            'records_d_remarks' => 'nullable|string|max:1000',
        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token);

        //dd($data);
        $data->records_a            = $request->records_a;
        $data->records_a_remarks    = $request->records_a_remarks;
        $data->records_b            = $request->records_b;
        $data->records_b_remarks    = $request->records_b_remarks;
        $data->records_c            = $request->records_c;
        $data->records_c_remarks    = $request->records_c_remarks;
        $data->records_d            = $request->records_d;
        $data->records_d_remarks    = $request->records_d_remarks;
        $data->records_status       = 1;


        $imagePath = 'images/ivca/food/';
        $records_a_image = $request->records_a_image; 
        $records_a_old_image = $data->records_a_image;
        // Save Image a
        if($records_a_image != $records_a_old_image){
            $imgName= $this->imageUplaodByName($records_a_image, $records_a_old_image, $imagePath); 
            $data->records_a_image = $imgName;
        }

        $records_b_image = $request->records_b_image; 
        $records_b_old_image = $data->records_b_image;
        // Save Image b
        if($records_b_image != $records_b_old_image){
            $imgName= $this->imageUplaodByName($records_b_image, $records_b_old_image, $imagePath); 
            $data->records_b_image = $imgName;
        }

        $records_c_image = $request->records_c_image; 
        $records_c_old_image = $data->records_c_image;
        // Save Image c
        if($records_c_image != $records_c_old_image){
            $imgName= $this->imageUplaodByName($records_c_image, $records_c_old_image, $imagePath); 
            $data->records_c_image = $imgName;
        }

        $records_d_image = $request->records_d_image; 
        $records_d_old_image = $data->records_d_image;
        // Save Image d
        if($records_d_image != $records_d_old_image){
            $imgName= $this->imageUplaodByName($records_d_image, $records_d_old_image, $imagePath); 
            $data->records_d_image = $imgName;
        }

       

        $data->save();

        return response()->json([ 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    //7 labeling_store
    public function labeling_store(Request $request, $token){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'labeling_a'         => 'required',
            'labeling_a_remarks' => 'nullable|string|max:1000',
            'labeling_b'         => 'required',
            'labeling_b_remarks' => 'nullable|string|max:1000',
            'labeling_c'         => 'required',
        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token);

        //dd($data);
        $data->labeling_a            = $request->labeling_a;
        $data->labeling_a_remarks    = $request->labeling_a_remarks;
        $data->labeling_b            = $request->labeling_b;
        $data->labeling_b_remarks    = $request->labeling_b_remarks;
        $data->labeling_c            = $request->labeling_c;
        $data->labeling_c_remarks    = $request->labeling_c_remarks;
        $data->labeling_status       = 1;


        $imagePath = 'images/ivca/food/';
        $labeling_a_image = $request->labeling_a_image; 
        $labeling_a_old_image = $data->labeling_a_image;
        // Save Image a
        if($labeling_a_image != $labeling_a_old_image){
            $imgName= $this->imageUplaodByName($labeling_a_image, $labeling_a_old_image, $imagePath); 
            $data->labeling_a_image = $imgName;
        }

        $labeling_b_image = $request->labeling_b_image; 
        $labeling_b_old_image = $data->labeling_b_image;
        // Save Image b
        if($labeling_b_image != $labeling_b_old_image){
            $imgName= $this->imageUplaodByName($labeling_b_image, $labeling_b_old_image, $imagePath); 
            $data->labeling_b_image = $imgName;
        }

        $labeling_c_image = $request->labeling_c_image; 
        $labeling_c_old_image = $data->labeling_c_image;
        // Save Image c
        if($labeling_c_image != $labeling_c_old_image){
            $imgName= $this->imageUplaodByName($labeling_c_image, $labeling_c_old_image, $imagePath); 
            $data->labeling_c_image = $imgName;
        }


        $data->save();

        return response()->json([ 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    // final_store
    public function final_store(Request $request, $token){

        //1 building_facilities_store
        $this->building_facilities_store($request, $token);
        //2 equipment_store
        $this->equipment_store($request, $token);
        //3 personnel_store
        $this->personnel_store($request, $token);
        //4 raw_materials_store
        $this->raw_materials_store($request, $token);
        //5 production_store
        $this->production_store($request, $token);
        //6 records_store
        $this->records_store($request, $token);
        //7 labeling_store
        $this->labeling_store($request, $token);
 
        // // Common audit data update
        $data = $this->commonUpdateData($token);


        // Image 1
        $currentImage   = $request->group_image; 
        $oldImage       = $data->group_image;
        $imagePath      = 'images/ivca/food/';
        // Save Image
        if($currentImage != $oldImage){
            $imgName= $this->imageUplaodByName($currentImage, $oldImage, $imagePath); 
            $data->group_image = $imgName;
        }

        $data->status = 1;
        $data->save();
 
        $data->status = 1;
        $data->save();
 
        return response()->json([ 'status'=>'Success', 'icon'=>'success', 'msg'=>'submission completed Successfully'], 200);
 
    }


    // common update data
    public function commonUpdateData($token){

        $today = date('Y-m-d');
        $user_id = Auth::user()->id;

        // Check Token tabl
        $tokenData = ivcaAuditFoodToken::where('token', $token)->where('date', $today)->first();

        $vendor_id      = $tokenData->vendor_id;
        $schedule_id    = $tokenData->schedule_id;
        $token_id       = $tokenData->id;

        if( $tokenData->status != 1 ){
           return response()->json('Token Not Found', 500);
        }

      
        // Audit Data
        $data = ivcaAuditFood::where('token', $token)
            ->where('created_by', $user_id)
            ->where('date', $today)
            ->first();

        if( empty($data) ){
            $data = new ivcaAuditFood();
        }

        // Common data
        $data->token        = $token;
        $data->vendor_id    = $vendor_id;
        $data->token_id     = $token_id;
        $data->schedule_id  = $schedule_id;
        $data->date         = $today;
        $data->created_by   = $user_id;
        $data->save();

        return $data;
        
    }
}
