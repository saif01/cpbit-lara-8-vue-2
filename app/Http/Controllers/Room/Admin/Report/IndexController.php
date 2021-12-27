<?php

namespace App\Http\Controllers\Room\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room\RoomBooking;
use Auth;

class IndexController extends Controller
{

    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = RoomBooking::with('room', 'bookby')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

   
   
}
