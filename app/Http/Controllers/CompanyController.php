<?php

namespace App\Http\Controllers;

use App\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends HomeController
{
    //show
    public function get_companies() {
        $companies = Company::where(['deleted'=>0])->select('id', 'name', 'account_number', 'address', 'zip_code', 'phone', 'local', 'created_at')->paginate(30);

        return view('backend.companies')->with(['companies'=>$companies]);
    }

    //delete
    public function post_delete_company(Request $request)
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
            Company::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Company deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Company could not be deleted!']);
        }
    }

    //add
    public function get_add_company() {
        return view('backend.company_add');
    }

    public function post_add_company(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'account_number' => 'required|string|max:20',
            'address' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:15',
            'local' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            $request->merge(['deleted'=>0]);

            Company::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Company added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Company could not be added!']);
        }
    }

    //update
    public function get_update_company($id) {
        $company = Company::where(['id'=>$id, 'deleted'=>0])->select('name', 'account_number', 'address', 'zip_code', 'phone', 'local')->first();

        return view('backend.company_update')->with(['company'=>$company]);
    }

    public function post_update_company($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'account_number' => 'required|string|max:20',
            'address' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:15',
            'local' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            unset($request['_token']);

            Company::where('id', $id)->update($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Company updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Company could not be updated!']);
        }
    }
}
