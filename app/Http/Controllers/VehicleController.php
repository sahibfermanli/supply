<?php

namespace App\Http\Controllers;

use App\Vehicles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehicleController extends HomeController
{
    public function get_vehicles() {
        $vehicles = Vehicles::where(['deleted'=>0])->select()->paginate(30);

        return view('backend.vehicles')->with(['vehicles'=>$vehicles]);
    }

    public function post_vehicles(Request $request) {
        if ($request->type == 'add') {
            //add vehicle
            return $this->add_vehicle($request);
        }
        else if ($request->type == 'delete') {
            //delete
            return $this->delete_vehicle($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //add
    private function add_vehicle(Request $request) {
        $validator = Validator::make($request->all(), [
            'Marka' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Lazımlı xanaları doldurun!']);
        }
        try {
            $request->merge(['deleted'=>0, 'edited_by'=>Auth::user()->name.' '.Auth::user()->surname]);

            Vehicles::create($request->all());

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Texnika əlavə edildi!', 'type' => 'add']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //delete
    private function delete_vehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'row_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id not found!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();
            Vehicles::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Texnika silindi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
