<?php

namespace App\Http\Controllers;

use App\Deadlines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeadlineController extends HomeController
{
    //show
    public function get_deadlines() {
        $deadlines = Deadlines::where(['deleted'=>0])->select('id', 'deadline', 'color', 'type', 'created_at')->paginate(30);
//print_r($deadlines);
//return;
        return view('backend.deadlines')->with(['deadlines'=>$deadlines]);
    }

    //delete
    public function post_delete_deadline(Request $request)
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
            Deadlines::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Deadline deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Deadline could not be deleted!']);
        }
    }

    //add
    public function get_add_deadline() {
        return view('backend.deadline_add');
    }

    public function post_add_deadline(Request $request) {
        $validator = Validator::make($request->all(), [
            'deadline' => 'required|integer',
            'color' => 'required|string|max:30',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            $request->merge(['deleted'=>0]);

            Deadlines::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Deadline added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Deadline could not be added!']);
        }
    }

    //update
    public function get_update_deadline($id) {
        $deadline = Deadlines::where(['id'=>$id, 'deleted'=>0])->select('deadline', 'color', 'type')->first();

        return view('backend.deadline_update')->with(['deadline'=>$deadline]);
    }

    public function post_update_deadline($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'deadline' => 'required|integer',
            'color' => 'required|string|max:30',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            unset($request['_token']);

            Deadlines::where('id', $id)->update($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Deadline updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Deadline could not be updated!']);
        }
    }
}
