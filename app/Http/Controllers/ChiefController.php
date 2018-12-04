<?php

namespace App\Http\Controllers;

use App\Departments;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChiefController extends HomeController
{
    //show
    public function get_chiefs() {
        $chiefs = User::leftJoin('Departments as d', 'users.DepartmentId', '=', 'd.id')->where(['d.deleted'=>0, 'users.deleted'=>0, 'users.chief'=>1])->select('users.id', 'users.name', 'users.surname', 'users.email', 'users.created_at', 'd.Department')->paginate(30);

        return view('backend.chiefs')->with(['chiefs'=>$chiefs]);
    }

    //delete
    public function post_delete_chief(Request $request)
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
            User::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Chief deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Chief could not be deleted!']);
        }
    }

    //add
    public function get_add_chief() {
        $departments = Departments::where(['deleted'=>0])->select('id', 'Department')->get();

        return view('backend.chief_add')->with(['departments'=>$departments]);
    }

    public function post_add_chief(Request $request) {
        $validator = Validator::make($request->all(), [
            'DepartmentID' => 'required|integer',
            'name' => 'required|string|max:191',
            'surname' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            $slug = str_slug($request->name.'-'.$request->surname.'-'.microtime());

            $pass = bcrypt($request->password);
            unset($request['password']);

            $request->merge(['slug'=>$slug, 'deleted'=>0, 'chief'=>1, 'confirmed'=>1, 'password'=>$pass]);

            User::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Chief added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Chief could not be added!']);
        }
    }

    //update
    public function get_update_chief($id) {
        $departments = Departments::where(['deleted'=>0])->select('id', 'Department')->get();
        $chief = User::where(['id'=>$id, 'deleted'=>0, 'chief'=>1])->select('id', 'DepartmentID', 'name', 'surname', 'email')->first();

        return view('backend.chief_update')->with(['departments'=>$departments, 'chief'=>$chief]);
    }

    public function post_update_chief($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'DepartmentID' => 'required|integer',
            'name' => 'required|string|max:191',
            'surname' => 'required|string|max:191',
            //'email' => 'required|email|max:191|unique:users,id,'.$id,
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            unset($request['_token']);

            if (!empty($request->password)) {
                $pass = bcrypt($request->password);
                unset($request['password']);
                $request->merge(['password'=>$pass]);
            }
            else {
                unset($request['password']);
            }

            User::where('id', $id)->update($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Chief updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Chief could not be updated!']);
        }
    }
}
