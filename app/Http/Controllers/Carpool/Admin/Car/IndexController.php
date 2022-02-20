<?php

namespace App\Http\Controllers\Carpool\Admin\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolCar;
use Illuminate\Support\Str;
use DataTables;
use Validator;
use Gate;
use Image;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Common\ImageUpload;

class IndexController extends Controller
{

    use ImageUpload;

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = CarpoolCar::with('makby')
            ->where('delete_temp', '!=', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }


    // status
    public function status($id){

        $data       =  CarpoolCar::find($id);
        if($data){

           $status = $data->status;
           
            if($status == 1){
                $data->status = null;
            }else{
                $data->status = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }

    // temporary
    public function temporary($id){

        $data       =  CarpoolCar::find($id);
        if($data){

           $temporary = $data->temporary;
           
            if($temporary == 1){
                $data->temporary = 0;
            }else{
                $data->temporary = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }


    // store
    public function store(Request $request){


        //Validate
        $this->validate($request,[
            'name'      => 'required',
            'number'    => 'required|unique:carpool_cars|max:50',
            'capacity'  => 'required',
            'remarks'   => 'nullable|max:1000',
            'status'    => 'required',
            'temporary' => 'required'
        ]);

        $data = new CarpoolCar();



        $imagePath      = 'images/carpool/car/';
        // Save Image 
        $current_image  = $request->image; 
        if(!empty($current_image)){
            $imgName= $this->imageUplaodByName($current_image, null, $imagePath); 
            $data->image = $imgName;
        }

        // Save Image 2
        $current_image2  = $request->image2; 
        if(!empty($current_image2)){
            $imgName2= $this->imageUplaodByName($current_image2, null, $imagePath); 
            $data->image2 = $imgName2;
        }

        // Save Image 3
        $current_image3  = $request->image3; 
        if(!empty($current_image3)){
            $imgName3= $this->imageUplaodByName($current_image3, null, $imagePath); 
            $data->image3 = $imgName3;
        }

    
        $data->name         = $request->name;
        $data->capacity     = $request->capacity;
        $data->temporary    = $request->temporary;
        $data->status       = $request->status;
        $data->number       = $request->number;
        $data->remarks      = $request->remarks;
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


     // update
    public function update(Request $request, $id){


        //Validate
        $this->validate($request,[
            'name'      => 'required',
            'number'    => 'required',
            'capacity'  => 'required',
            'remarks'   => 'nullable|max:1000',
            'status'    => 'nullable',
            'temporary' => 'nullable'
        ]);

        $data = CarpoolCar::find($id);


        $imagePath      = 'images/carpool/car/';
        // Save Image 
        $current_image  = $request->image; 
        $old_image      = $data->image;
        if($current_image != $old_image){
            $imgName= $this->imageUplaodByName($current_image, $old_image, $imagePath); 
            $data->image = $imgName;
        }

        // Save Image 2
        $current_image2  = $request->image2;
        $old_image2      = $data->image2; 
        if(!empty($current_image2 != $old_image2)){
            $imgName2= $this->imageUplaodByName($current_image2, $old_image2, $imagePath); 
            $data->image2 = $imgName2;
        }
        $current_image3  = $request->image3; 

        // Save Image 3
        $current_image3  = $request->image3; 
        $old_image3      = $data->image3;
        if($current_image3 != $old_image3){
            $imgName3= $this->imageUplaodByName($current_image3, $old_image, $imagePath); 
            $data->image3 = $imgName3;
        }

      
        $data->name         = $request->name;
        $data->capacity     = $request->capacity;
        $data->temporary    = $request->temporary;
        $data->status       = $request->status;
        $data->number       = $request->number;
        $data->remarks      = $request->remarks;

        $data->created_by =  Auth::user()->id;
        $success          = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    


    
    //DeadlineStore
    public function deadlineStore(Request $request)
    {

        
        // update id start
        $id     =  $request->id;
        $data   =  CarpoolCar::find($id);
        //end update id

        $data->last_use = $request->last_use;
        $success = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    //DeadlineClear
    public function deadlineClear($id){

        $data            = CarpoolCar::find($id);
        $data->last_use  = null;
        $success         =$data->save();
        if($success){
            return response()->json(['msg'=>'Deadline Cleared Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    //Delete
    public function destroyTemp($id){


        $data               = CarpoolCar::findOrFail($id);
        $data->delete_temp  = 1;
        $data->delete_by    = Auth::user()->id;
        $data->updated_at   = Carbon::now();
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Deleted Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data is not deleted !!'
            ], 422);
        }
    }


    //All Delete Data
    public function DeleteAll(){

        if(request()->ajax())
        {
            $data = CarpoolCar::with('user')->where('delete_temp', 1)->get();

            return DataTables::of($data)

                    ->addColumn('imageSrc', function($data){

                        $url1=asset("$data->image_small");
                        $url2=asset("$data->image2_small");
                        $url3=asset("$data->image3_small");
                        $button = '<img src='.$url1.' width="100" height="100" class="img-thumbnail" />';
                        $button .= '<img src='.$url2.' width="100" height="100" class="img-thumbnail" />';
                        $button .= '<img src='.$url3.' width="100" height="100" class="img-thumbnail" />';
                        return $button;
                    })

                    ->addColumn('details', function($data){
                        $button = '';
                        $button .='<b>Name: </b> &nbsp;'.$data->name. '<br>';
                        $button .='<b>Capacity: </b> &nbsp;'.$data->capacity. '<br>';
                        if($data->temporary == 1){
                            $button .= '<p class=" mb-0 d-inline-block"> <b>Car Type: </b> Regular</p><br>';
                          }else{
                              $button .= '<p class="mb-0 d-inline-block"> <b>Car Type: </b> Temporary</p><br>';
                          }
                        $button .='<b>Remarks: </b> &nbsp;'.$data->remarks. '<br>';
                        return $button;
                    })

                    ->addColumn('deleteInfo', function($data){
                        $url=asset($data->user->image_small);
                        $button = '<button type="button" id="'.$data->user->id.'" class="userInfoDetail btn"><img src='.$url.' width="100" height="100" class="img-thumbnail" /></button>';

                        $button .='<button type="button" id="'.$data->user->id.'" class="userInfoDetail btn btn-secondary"> <i class="fa fa-eye" ></i> '.$data->user->name.'</button><br>';
                        $button .='Deleted Time: '. date("F j, Y, g:i a", strtotime($data->updated_at)) .'<br>';

                        return $button;
                    })



                    ->addColumn('action', function($data){

                        $button = '';
                        $button .= '<button id="'.$data->id.'" class="delete btn btn-danger btn-sm mr-1" ><i class="fa fa-trash" ></i> Delete </button>';
                        $button .= '<button id="'.$data->id.'" class="restore btn btn-success btn-sm" ><i class="fas fa-trash-restore" ></i> Restore </button>';
                        return $button;
                    })


                    ->rawColumns(['imageSrc','details','deleteInfo','action'])
                    ->make(true);
        }



        return view('admin.carpool.cars.delete');
    }


    //Restore
    public function Restore($id){

        if(Gate::denies('administration')){
            return response()->json(['success' => 'Sorry !! You have no access.', 'icon' => 'error']);
        }

        $data = CarpoolCar::findOrFail($id);
        $data->delete_temp  = 0;
        $data->delete_by    = Auth::user()->id;
        $data->updated_at   = Carbon::now();
        $success            = $data->save();

        if($success){
            return response()->json(['success' => 'Successfully Restore', 'icon' => 'success']);
        }else{
            return response()->json(['success' => 'Something going wrong !!', 'icon' => 'error']);
        }
    }


    //Delete Permanent
    public function DeletePermanent($id){

        if(Gate::denies('administration')){
            return response()->json(['success' => 'Sorry !! You have no access.', 'icon' => 'error']);
        }

        $data = CarpoolCar::findOrFail($id);

        $imgName1 =$data->image;
        $imgName1_small =$data->image_small;
        $imgName2 =$data->image2;
        $imgName2_small =$data->image2_small;
        $imgName3 =$data->image3;
        $imgName3_small =$data->image3_small;

        //check this image have or  not in data base

        if(file_exists($imgName1)){
            unlink($imgName1);
        }

        if(file_exists($imgName1_small)){
            unlink($imgName1_small);
        }

        if(file_exists($imgName2)){
            unlink($imgName2);
        }

        if(file_exists($imgName2_small)){
            unlink($imgName2_small);
        }

        if(file_exists($imgName3)){
            unlink($imgName3);
        }

        if(file_exists($imgName3_small)){
            unlink($imgName3_small);
        }

        $success = $data->delete();

        if($success){
            return response()->json(['success' => 'Successfully Deleted', 'icon' => 'success']);
        }else{
            return response()->json(['success' => 'Something going wrong !!', 'icon' => 'error']);
        }
    }




}

