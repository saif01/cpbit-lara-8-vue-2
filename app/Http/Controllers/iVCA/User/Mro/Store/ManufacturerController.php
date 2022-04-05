<?php

namespace App\Http\Controllers\iVCA\User\Mro\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaAuditMroToken;
use Auth;
use App\User;
use Illuminate\Support\Str;
use Image;
use File;

use App\Models\iVca\ivcaAuditMroManufacturer; 

use App\Http\Controllers\iVCA\User\Common\CommonFunctions; 

class ManufacturerController extends Controller
{

    use CommonFunctions;

    // audit_data
    public function audit_data($token){

        $today = date('Y-m-d');
        $user_id = Auth::user()->id;
       
        // Audit Data
        $data = ivcaAuditMroManufacturer::where('token', $token)
            ->where('created_by', $user_id)
            ->where('date', $today)
            ->first();

        //dd($token, $data);
        return response()->json($data, 200);


    }

    // storage_store
    public function storage_store(Request $request, $token, $type){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'storage_1'         => 'required',
            'storage_1_remarks' => 'nullable|string|max:1000',
            'storage_2'         => 'required',
            'storage_2_remarks' => 'nullable|string|max:1000',
            'storage_3'         => 'required',
            'storage_3_remarks' => 'nullable|string|max:1000',
            'storage_4'         => 'required',
            'storage_4_remarks' => 'nullable|string|max:1000',

        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token, $type);

        //dd($data);
        $data->storage_1            = $request->storage_1;
        $data->storage_1_remarks    = $request->storage_1_remarks;
        $data->storage_2            = $request->storage_2;
        $data->storage_2_remarks    = $request->storage_2_remarks;
        $data->storage_3            = $request->storage_3;
        $data->storage_3_remarks    = $request->storage_3_remarks;
        $data->storage_4            = $request->storage_4;
        $data->storage_4_remarks    = $request->storage_4_remarks;
        $data->storage_status       = 1;


        $currentImage = $request->storage_image; 
        $oldImage = $data->storage_image;
        $imagePath = 'images/ivca/';
        // Save Image
        if($currentImage != $oldImage){
            $imgName= $this->imageUplaodByName($currentImage, $oldImage, $imagePath); 
            $data->storage_image = $imgName;
        }
        

        $data->save();

        return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    //production_qs_store
    public function production_qs_store(Request $request, $token, $type){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'production_qs_1'         => 'required',
            'production_qs_1_remarks' => 'nullable|string|max:1000',
            'production_qs_2'         => 'required',
            'production_qs_2_remarks' => 'nullable|string|max:1000',
            'production_qs_3'         => 'required',
            'production_qs_3_remarks' => 'nullable|string|max:1000',
            'production_qs_4'         => 'required',
            'production_qs_4_remarks' => 'nullable|string|max:1000',

        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token, $type);

        //dd($data);
        $data->production_qs_1          = $request->production_qs_1;
        $data->production_qs_1_remarks  = $request->production_qs_1_remarks;
        $data->production_qs_2          = $request->production_qs_2;
        $data->production_qs_2_remarks  = $request->production_qs_2_remarks;
        $data->production_qs_3          = $request->production_qs_3;
        $data->production_qs_3_remarks  = $request->production_qs_3_remarks;
        $data->production_qs_4          = $request->production_qs_4;
        $data->production_qs_4_remarks  = $request->production_qs_4_remarks;
        $data->production_qs_status     = 1;


        $currentImage = $request->production_qs_image; 
        $oldImage = $data->production_qs_image;
        $imagePath = 'images/ivca/';
        // Save Image
        if($currentImage != $oldImage){
            $imgName= $this->imageUplaodByName($currentImage, $oldImage, $imagePath); 
            $data->production_qs_image = $imgName;
        }

        $data->save();

        return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    // safety_store
    public function safety_store(Request $request, $token, $type){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'safety_1'         => 'required',
            'safety_1_remarks' => 'nullable|string|max:1000',
            'safety_2'         => 'required',
            'safety_2_remarks' => 'nullable|string|max:1000',
            'safety_3'         => 'required',
            'safety_3_remarks' => 'nullable|string|max:1000',
            'safety_4'         => 'required',
            'safety_4_remarks' => 'nullable|string|max:1000',

        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token, $type);

        //dd($data);
        $data->safety_1          = $request->safety_1;
        $data->safety_1_remarks  = $request->safety_1_remarks;
        $data->safety_2          = $request->safety_2;
        $data->safety_2_remarks  = $request->safety_2_remarks;
        $data->safety_3          = $request->safety_3;
        $data->safety_3_remarks  = $request->safety_3_remarks;
        $data->safety_4          = $request->safety_4;
        $data->safety_4_remarks  = $request->safety_4_remarks;
        $data->safety_status     = 1;



        $currentImage = $request->safety_image; 
        $oldImage = $data->safety_image;
        $imagePath = 'images/ivca/';
        // Save Image
        if($currentImage != $oldImage){
            $imgName= $this->imageUplaodByName($currentImage, $oldImage, $imagePath); 
            $data->safety_image = $imgName;
        }

        $data->save();

        return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    // env_sur_con_store
    public function env_sur_con_store(Request $request, $token, $type){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'env_sur_con_1'         => 'required',
            'env_sur_con_1_remarks' => 'nullable|string|max:1000',
            'env_sur_con_2'         => 'required',
            'env_sur_con_2_remarks' => 'nullable|string|max:1000',
            'env_sur_con_3'         => 'required',
            'env_sur_con_3_remarks' => 'nullable|string|max:1000',
            'env_sur_con_4'         => 'required',
            'env_sur_con_4_remarks' => 'nullable|string|max:1000',

        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token, $type);

        //dd($data);
        $data->env_sur_con_1          = $request->env_sur_con_1;
        $data->env_sur_con_1_remarks  = $request->env_sur_con_1_remarks;
        $data->env_sur_con_2          = $request->env_sur_con_2;
        $data->env_sur_con_2_remarks  = $request->env_sur_con_2_remarks;
        $data->env_sur_con_3          = $request->env_sur_con_3;
        $data->env_sur_con_3_remarks  = $request->env_sur_con_3_remarks;
        $data->env_sur_con_4          = $request->env_sur_con_4;
        $data->env_sur_con_4_remarks  = $request->env_sur_con_4_remarks;
        $data->env_sur_con_status     = 1;



        $currentImage = $request->env_sur_con_image; 
        $oldImage = $data->env_sur_con_image;
        $imagePath = 'images/ivca/';
        // Save Image
        if($currentImage != $oldImage){
            $imgName= $this->imageUplaodByName($currentImage, $oldImage, $imagePath); 
            $data->env_sur_con_image = $imgName;
        }

        $data->save();

        return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }



    // equipment_store
    public function equipment_store(Request $request, $token, $type){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'equipment_1'         => 'required',
            'equipment_1_remarks' => 'nullable|string|max:1000',
            'equipment_2'         => 'required',
            'equipment_2_remarks' => 'nullable|string|max:1000',
            'equipment_3'         => 'required',
            'equipment_3_remarks' => 'nullable|string|max:1000',

        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token, $type);

        //dd($data);
        $data->equipment_1          = $request->equipment_1;
        $data->equipment_1_remarks  = $request->equipment_1_remarks;
        $data->equipment_2          = $request->equipment_2;
        $data->equipment_2_remarks  = $request->equipment_2_remarks;
        $data->equipment_3          = $request->equipment_3;
        $data->equipment_3_remarks  = $request->equipment_3_remarks;
        $data->equipment_status     = 1;
        


        $currentImage = $request->equipment_image; 
        $oldImage = $data->equipment_image;
        $imagePath = 'images/ivca/';
        // Save Image
        if($currentImage != $oldImage){
            $imgName= $this->imageUplaodByName($currentImage, $oldImage, $imagePath); 
            $data->equipment_image = $imgName;
        }

        $data->save();

        return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }


    // cooperate_store
    public function cooperate_store(Request $request, $token, $type){

        // dd( $type, $request->all() );

        //// Validate
        $this->validate($request,[
            'cooperate_1'         => 'required',
            'cooperate_1_remarks' => 'nullable|string|max:1000',
            'cooperate_2'         => 'required',
            'cooperate_2_remarks' => 'nullable|string|max:1000',
            'cooperate_3'         => 'required',
            'cooperate_3_remarks' => 'nullable|string|max:1000',
        ]);

        
        // Common audit data update
        $data = $this->commonUpdateData($token, $type);

        //dd($data);
        $data->cooperate_1          = $request->cooperate_1;
        $data->cooperate_1_remarks  = $request->cooperate_1_remarks;
        $data->cooperate_2          = $request->cooperate_2;
        $data->cooperate_2_remarks  = $request->cooperate_2_remarks;
        $data->cooperate_3          = $request->cooperate_3;
        $data->cooperate_3_remarks  = $request->cooperate_3_remarks;
        $data->cooperate_status     = 1;


        $currentImage = $request->cooperate_image; 
        $oldImage = $data->cooperate_image;
        $imagePath = 'images/ivca/';
        // Save Image
        if($currentImage != $oldImage){
            $imgName= $this->imageUplaodByName($currentImage, $oldImage, $imagePath); 
            $data->cooperate_image = $imgName;
        }

        $data->save();

        return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }



    // final_store
    public function final_store(Request $request, $token, $type){

        // Validation only for Auditor
        if( $type != 'User' ){
            //// Validate
            $this->validate($request,[
                'group_image'         => 'required',
                'vendor_image'        => 'required',
            ]);
        }

       //storage_store
       $this->storage_store($request, $token, $type);
       // production_qs_store
       $this->production_qs_store($request, $token, $type);
       // safety_store
       $this->safety_store($request, $token, $type);
       // env_sur_con_store
       $this->env_sur_con_store($request, $token, $type);
       // equipment_store
       $this->equipment_store($request, $token, $type);
       // cooperate_store
       $this->cooperate_store($request, $token, $type);

       // // Common audit data update
       $data = $this->commonUpdateData($token, $type);

        // Image 1
        $currentImage   = $request->group_image; 
        $oldImage       = $data->group_image;
        $imagePath      = 'images/ivca/';
        // Save Image
        if($currentImage != $oldImage){
            $imgName= $this->imageUplaodByName($currentImage, $oldImage, $imagePath); 
            $data->group_image = $imgName;
        }

        // Image 2
        $currentImage2   = $request->vendor_image; 
        $oldImage2       = $data->vendor_image;
        // Save Image
        if($currentImage2 != $oldImage2){
            $imgName2= $this->imageUplaodByName($currentImage2, $oldImage2, $imagePath); 
            $data->vendor_image = $imgName2;
        }

        $data->status = 1;
        $data->save();

        return response()->json([ 'allData'=>$data, 'status'=>'Success', 'icon'=>'success', 'msg'=>'Update Successfully'], 200);

    }





    // common update data
    public function commonUpdateData($token, $type){

        $today = date('Y-m-d');
        $user_id = Auth::user()->id;

        // Check Token tabl
        $tokenData = ivcaAuditMroToken::where('token', $token)->where('date', $today)->first();

        $vendor_id      = $tokenData->vendor_id;
        $schedule_id    = $tokenData->schedule_id;
        $token_id       = $tokenData->id;

        if( $tokenData ){
            // update token table data
            $tokenData->template = 'mro_manufacturer';
            $tokenData->audit_status = 1;
            $tokenData->save();
        }

      
        // Audit Data
        $data = ivcaAuditMroManufacturer::where('token', $token)
            ->where('created_by', $user_id)
            ->where('date', $today)
            ->first();

        if( empty($data) ){
            $data = new ivcaAuditMroManufacturer();
        }

        // Common data
        $data->token        = $token;
        $data->vendor_id    = $vendor_id;
        $data->token_id     = $token_id;
        $data->schedule_id  = $schedule_id;
        $data->date         = $today;
        $data->type         = $type;
        $data->created_by   = $user_id;
        $data->save();

        return $data;
        
    }
}
