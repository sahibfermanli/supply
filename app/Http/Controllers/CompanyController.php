<?php

namespace App\Http\Controllers;

use App\Company;
use App\Sellers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    //show
    public function get_companies() {
        $companies = Sellers::where(['deleted'=>0])->orderBy('seller_name')->select('*')->paginate(30);

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
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //delete
    private function delete_company(Request $request)
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
            Sellers::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Satıcı silindi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //add
    private function add_company(Request $request) {
        $validator = Validator::make($request->all(), [
            'seller_name' => 'required|string|max:255',
            'seller_director' => 'required|string|max:150',
            'seller_voen' => 'required|string|max:100',
            'seller_account_no' => 'required|string|max:100',
            'bank_name' => 'required|string|max:255',
            'bank_voen' => 'required|string|max:100',
            'bank_code' => 'required|string|max:30',
            'bank_m_n' => 'required|string|max:100',
            'bank_swift' => 'required|string|max:50',
            'contract_no' => 'required|string|max:50',
            'contract_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Lazımlı xanaları doldurun!']);
        }
        try {
            $request->merge(['deleted'=>0, 'edited_ip'=>Auth::user()->name.' '.Auth::user()->surname]);

            Sellers::create($request->all());

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Satıcı əlavə edildi!', 'type' => 'add_company']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    private function update_company(Request $request) {
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
