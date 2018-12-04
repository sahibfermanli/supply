<?php

namespace App\Http\Controllers;

use App\Authorities;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorityController extends HomeController
{
    //show
    public function get_authorities() {
        $authorities = Authorities::where(['deleted'=>0])->select('id', 'title', 'created_at')->paginate(30);

        return view('backend.authorities')->with(['authorities'=>$authorities]);
    }

    //delete
    public function post_delete_authority(Request $request)
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
            Authorities::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Authority deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Authority could not be deleted!']);
        }
    }

    //add
    public function get_add_authority() {
        return view('backend.authority_add');
    }

    public function post_add_authority(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            $request->merge(['deleted'=>0]);

            Authorities::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Authority added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Authority could not be added!']);
        }
    }

    //update
    public function get_update_authority($id) {
        $authority = Authorities::where(['id'=>$id, 'deleted'=>0])->select('id', 'title')->first();

        return view('backend.authority_update')->with(['authority'=>$authority]);
    }

    public function post_update_authority($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            unset($request['_token']);

            Authorities::where('id', $id)->update($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Authority updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Authority could not be updated!']);
        }
    }
}
