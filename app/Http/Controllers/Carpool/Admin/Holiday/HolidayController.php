<?php

namespace App\Http\Controllers\Admin\Carpool\Holiday;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Carpool\CarpoolHoliday;
use Illuminate\Support\Str;
use DataTables;
use Validator;
use Gate;
use Carbon\Carbon;
use Auth;


class HolidayController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    //All Data
    public function All(){


        if(request()->ajax())
        {
            $data = CarpoolHoliday::latest('id');


            return DataTables::of($data)


                ->addColumn('action', function($data){

                    $button = '';

                    if( Gate::allows('edit') ){
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm" ><i class="fa fa-pencil-square-o"></i> Edit</button>';
                    }

                    if( Gate::allows('delete') ){
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Delete</button>';
                    }

                    if(empty($button)){
                        return '<span class="text-danger">  No Access</span>';
                    }

                    return $button;
                })

                ->rawColumns(['startDate', 'endDate', 'action'])
                ->make(true);
        }


        return view('admin.carpool.holiday.all');
    }


    //insert
    public function Store(Request $request)
    {
        if(Gate::denies(['insert'])){
             return response()->json(['success' => 'Sorry !! You have no access.', 'icon' => 'error']);
        }


        $rules = array(
            'title'    =>  'required',
            'start'    =>  'required',
            'end'      =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        else{


            $data = new CarpoolHoliday();

            $data->title    = $request->title;
            $data->start    = $request->start;;
            $data->end      = $request->end;
            $data->remarks  = $request->remarks;
            $success = $data->save();


            if($success){
                return response()->json(['success' => 'Successfully Inserted', 'icon' => 'success']);
            }else{
                return response()->json(['success' => 'Something going wrong !!', 'icon' => 'error']);
            }
        }



    }

    //Edit
    public function Edit($id){


        $data = CarpoolHoliday::findOrFail($id);

        if(request()->ajax())
        {
            $data = CarpoolHoliday::findOrFail($id);
            return response()->json($data);
        }
    }

    //Update
    public function Update(Request $request){

        if(Gate::denies('edit')){
            return response()->json(['success' => 'Sorry !! You have no access.', 'icon' => 'error']);
        }

        $id = $request->hidden_id;

        $rules = array(
            'title'    =>  'required',
            'start'    =>  'required',
            'end'      =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        else
        {


            $data = CarpoolHoliday::findOrFail($id);

            $data->title    = $request->title;
            $data->start    = $request->start;;
            $data->end      = $request->end;
            $data->remarks  = $request->remarks;
            $success = $data->save();


            if($success){
                return response()->json(['success' => 'Successfully Updated', 'icon' => 'success']);
            }else{
                return response()->json(['success' => 'Something going wrong !!', 'icon' => 'error']);
            }

        }



    }


    //Delete
    public function Delete($id){

        if(Gate::denies('delete')){
            return response()->json(['success' => 'Sorry !! You have no access.', 'icon' => 'error']);
        }

        $data       = CarpoolHoliday::findOrFail($id);
        $success    = $data->delete();

        if($success){
            return response()->json(['success' => 'Successfully Deleted', 'icon' => 'success']);
        }else{
            return response()->json(['success' => 'Something going wrong !!', 'icon' => 'error']);
        }
    }



}
