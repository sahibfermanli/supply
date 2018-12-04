<?php

namespace App\Http\Controllers;

use App\Situations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SituationController extends HomeController
{
    //show
    public function get_situations() {
        $situations = Situations::where(['deleted'=>0])->select('id', 'status', 'color', 'created_at')->paginate(30);

        return view('backend.situations')->with(['situations'=>$situations]);
    }

    //delete
    public function post_delete_situation(Request $request)
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
            Situations::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Situation deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Situation could not be deleted!']);
        }
    }

    //add
    public function get_add_situation() {
        return view('backend.situation_add');
    }

    public function post_add_situation(Request $request) {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:50',
            'color' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            $request->merge(['deleted'=>0]);

            Situations::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Situation added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Situation could not be added!']);
        }
    }

    //update
    public function get_update_situation($id) {
        $situation = Situations::where(['id'=>$id, 'deleted'=>0])->select('status', 'color')->first();

        return view('backend.situation_update')->with(['situation'=>$situation]);
    }

    public function post_update_situation($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:50',
            'color' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            unset($request['_token']);

            Situations::where('id', $id)->update($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Situation updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Situation could not be updated!']);
        }
    }
}
