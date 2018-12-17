<?php

namespace App\Http\Controllers;

use App\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    //show
    public function get_companies() {
        $companies = Company::where(['deleted'=>0])->select('id', 'name', 'address', 'zip_code', 'fax', 'phone', 'local', 'created_at')->paginate(30);

        return view('backend.companies')->with(['companies'=>$companies]);
    }

    public function post_companies(Request $request) {
        if ($request->type == 'delete') {
            //delete
            return $this->delete_company($request);
        }
        else if ($request->type == 'add') {
            //add
            return $this->add_company($request);
        }
        else if ($request->type == 'update') {
            //update
            return $this->update_company($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //delete
    public function delete_company(Request $request)
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
    public function add_company(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:30',
            'fax' => 'required|string|max:30',
            'local' => 'integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Lazımlı xanaları doldurun!']);
        }
        try {
            $request->merge(['deleted'=>0]);

            Company::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Şirkət əlavə edildi!', 'type' => 'add_company']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Səhv baş verdi!']);
        }
    }

    public function update_company(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:30',
            'fax' => 'required|string|max:30',
            'local' => 'integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Lazımlı xanaları doldurun!']);
        }
        try {
            $id = $request->id;
            unset($request['id'], $request['_token'], $request['type']);

            Company::where('id', $id)->update($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Məlumatlar dəyişdirildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
