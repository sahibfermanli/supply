<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends HomeController
{
    //show
    public function get_admins() {
        $admins = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['users.deleted'=>0, 'd.authority_id'=>1])->select('users.id', 'users.name', 'users.surname', 'users.email', 'users.created_at')->paginate(30);

        return view('backend.admins')->with(['admins'=>$admins]);
    }

    //delete
    public function post_delete_admin(Request $request)
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

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Admin deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Admin could not be deleted!']);
        }
    }

    //add
    public function get_add_admin() {
        return view('backend.admin_add');
    }

    public function post_add_admin(Request $request) {
        $validator = Validator::make($request->all(), [
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

            $request->merge(['slug'=>$slug, 'deleted'=>0, 'DepartmentID'=>6, 'confirmed'=>1, 'password'=>$pass]);

            User::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Admin added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Admin could not be added!']);
        }
    }

    //update
    public function get_update_admin($id) {
       $admin = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['users.id'=>$id, 'users.deleted'=>0, 'd.authority_id'=>1])->select('users.id', 'users.name', 'users.surname', 'users.email')->first();

        return view('backend.admin_update')->with(['admin'=>$admin]);
    }

    public function post_update_admin($id, Request $request) {
        $validator = Validator::make($request->all(), [
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

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Admin updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Admin could not be updated!']);
        }
    }
}
