<?php

namespace App\Http\Controllers;

use App\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function get_sellers_form(Request $request) {
        $ip_address = $request->ip();

        if (Sellers::where(['edited_ip'=>$ip_address, 'deleted'=>0])->count() > 0) {
            $seller = Sellers::where(['edited_ip'=>$ip_address, 'deleted'=>0])->orderBy('id', 'DESC')->select()->first();
        }
        else {
            $seller = array();
        }

        return view('backend.seller_form')->with('seller', $seller);
    }

    public function post_sellers_form(Request $request) {
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
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Bütün məlumatları daxil edin!']);
        }
        try {
            $ip_address = $request->ip();

            if (Sellers::where(['edited_ip'=>$ip_address, 'deleted'=>0])->count() > 0) {
                //update
                unset($request['_token']);
                Sellers::where(['edited_ip'=>$ip_address, 'deleted'=>0])->update($request->all());
            }
            else {
                //create
                $request->merge(['edited_ip'=>$ip_address]);
                Sellers::create($request->all());
            }

            Session::flash('message', 'Təşəkkür edirik!');
            Session::flash('class', 'success');
            Session::flash('display', 'block');
            return redirect('/sellers');
        } catch (\Exception $e) {
            Session::flash('message', 'Səhv baş verdi!');
            Session::flash('class', 'danger');
            Session::flash('display', 'block');
            return redirect('/sellers');
        }
    }
}
