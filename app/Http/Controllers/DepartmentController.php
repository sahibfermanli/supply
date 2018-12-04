<?php

namespace App\Http\Controllers;

use App\Authorities;
use App\Departments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends HomeController
{
    //show
    public function get_departments() {
        $departments = Departments::leftJoin('authorities as a', 'Departments.authority_id', '=', 'a.id')->where(['Departments.deleted'=>0])->select('Departments.id', 'Departments.Department', 'Departments.Company', 'Departments.created_at', 'a.title as authority')->paginate(30);

        return view('backend.departments')->with(['departments'=>$departments]);
    }

    //delete
    public function post_delete_department(Request $request)
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
            Departments::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Department deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Department could not be deleted!']);
        }
    }

    //add
    public function get_add_department() {
        $authorities = Authorities::where(['deleted'=>0])->select('id', 'title')->get();

        return view('backend.department_add')->with(['authorities'=>$authorities]);
    }

    public function post_add_department(Request $request) {
        $validator = Validator::make($request->all(), [
            'Department' => 'required|string|max:255',
            'Company' => 'required|string|max:255',
            'authority_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            $request->merge(['deleted'=>0]);

            Departments::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Department added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Department could not be added!']);
        }
    }

    //update
    public function get_update_department($id) {
        $department = Departments::where(['id'=>$id, 'deleted'=>0])->select('id', 'Department', 'Company', 'authority_id')->first();
        $authorities = Authorities::where(['deleted'=>0])->select('id', 'title')->get();

        return view('backend.department_update')->with(['department'=>$department, 'authorities'=>$authorities]);
    }

    public function post_update_department($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'Department' => 'required|string|max:255',
            'Company' => 'required|string|max:255',
            'authority_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            unset($request['_token']);

            Departments::where('id', $id)->update($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Department updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Department could not be updated!']);
        }
    }
}
