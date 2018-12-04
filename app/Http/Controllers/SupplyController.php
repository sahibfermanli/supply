<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplyController extends HomeController
{
    //show
    public function get_supply_users() {
        $supply_users = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['users.deleted'=>0, 'd.authority_id'=>4])->select('users.id', 'users.name', 'users.surname', 'users.email', 'users.created_at')->paginate(30);

        return view('backend.supply_users')->with(['supply_users'=>$supply_users]);
    }

    //delete
    public function post_delete_supply_user(Request $request)
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

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'supplyUser deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'supplyUser could not be deleted!']);
        }
    }

    //add
    public function get_add_supply_user() {
        return view('backend.supply_user_add');
    }

    public function post_add_supply_user(Request $request) {
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

            $request->merge(['slug'=>$slug, 'deleted'=>0, 'authority'=>4, 'confirmed'=>1, 'password'=>$pass]);

            User::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'supplyUser added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'supplyUser could not be added!']);
        }
    }

    //update
    public function get_update_supply_user($id) {
        $supply_user = User::where(['id'=>$id, 'deleted'=>0, 'authority'=>4])->select('id', 'name', 'surname', 'email')->first();

        return view('backend.supply_user_update')->with(['supply_user'=>$supply_user]);
    }

    public function post_update_supply_user($id, Request $request) {
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

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'supplyUser updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'supplyUser could not be updated!']);
        }
    }
}
