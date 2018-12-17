<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Company;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AccountController extends HomeController
{
    public function get_accounts_for_supply() {
        $companies = Company::where(['deleted'=>0])->select('id', 'name')->orderBy('name')->get();
        $accounts = Accounts::where(['deleted'=>0])->select()->paginate(30);
        if (Auth::user()->chief() == 1) {
            $free_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('companies as c', 'Purchases.company_id', '=', 'c.id')->leftJoin('users', 'Purchases.delivery_person_id', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->whereNull('account_id')->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at')->get();
        }
        else {
            $free_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('companies as c', 'Purchases.company_id', '=', 'c.id')->leftJoin('users', 'Purchases.delivery_person_id', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.SupplyID'=>Auth::id()])->whereNull('account_id')->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at')->get();
        }

        return view('backend.accounts')->with(['accounts'=>$accounts, 'free_purchases'=>$free_purchases, 'companies'=>$companies]);
    }

    public function post_accounts_for_supply(Request $request) {
        if ($request->type == 'delete') {
            //delete
            return $this->delete_account($request);
        }
        else if ($request->type == 'add') {
            //add
            return $this->add_account($request);
        }
        else if ($request->type == 'update') {
            //update
            return $this->update_account($request);
        }
        else if ($request->type == 'update_doc') {
            //update document
            return $this->update_document($request);
        }
        else if ($request->type == 'show_purchases') {
            //show selected purchases
            return $this->show_selected_purchases($request);
        }
        else if ($request->type == 'add_purchase_to_selected_account') {
            //add purchase to selected account
            return $this->add_purchase_to_selected_account($request);
        }
        else if ($request->type == 'remove_purchase_from_selected_account') {
            //remove purchase from selected account
            return $this->remove_purchase_from_selected_account($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //delete account
    public function delete_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'row_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id tapılmadı!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();
            Accounts::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Silindi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Silinmə zamanı səhv baş verdi!']);
        }
    }

    //add account
    public function add_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_no' => 'required|string|max:50',
            'company_id' => 'required|integer',
            //'file' => 'required|mimes:doc,docx,pdf',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Bütün xanaları doldurun (fayl formatı: *.doc, *.docx, *.pdf)!']);
        }
        try {
            $file = Input::file('file');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = 'account_' . $request->account_no . '_' . str_random(4) . '_' . microtime() . '.' . $file_ext;
            Storage::disk('uploads')->makeDirectory('files/accounts');
            $file->move('uploads/files/accounts/', $file_name);
            $file_address = '/uploads/files/accounts/' . $file_name;

            $request->merge(['account_doc' => $file_address]);

            $request = Input::except('file');

            Accounts::create($request);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Hesab əlavə edildi!', 'type' => 'add_account']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //update account
    public function update_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'account_no' => 'required|string|max:50',
            'company_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Bütün xanaları doldurun!']);
        }
        try {
            $id = $request->id;
            unset($request['id'], $request['_token'], $request['type']);

            Accounts::where(['id'=>$id])->update($request->all());

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Hesab məlumatları dəyişdirildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //update document
    public function update_document(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'account_no' => 'required|string|max:50',
        ]);
        try {
            $file = Input::file('file');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = 'account_' . $request->account_no . '_' . str_random(4) . '_' . microtime() . '.' . $file_ext;
            Storage::disk('uploads')->makeDirectory('files/accounts');
            $file->move('uploads/files/accounts/', $file_name);
            $file_address = '/uploads/files/accounts/' . $file_name;

            Accounts::where(['id'=>$request->id])->update(['account_doc'=>$file_address]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Faly dəyişdirildi!', 'type' => 'update_doc']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //show purchases when clicked account
    public function show_selected_purchases(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
        }
        try {
            if (Auth::user()->chief() == 1) {
                $selected_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('companies as c', 'Purchases.company_id', '=', 'c.id')->leftJoin('users', 'Purchases.delivery_person_id', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$request->account_id])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at')->get();
            }
            else {
                $selected_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('companies as c', 'Purchases.company_id', '=', 'c.id')->leftJoin('users', 'Purchases.delivery_person_id', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$request->account_id, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at')->get();
            }

            return response(['case' => 'success', 'selected_purchases'=>$selected_purchases]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //add purchase to selected account
    public function add_purchase_to_selected_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|integer',
            'purchase_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab və ya sifariş tapılmadı!']);
        }
        try {
            $update = Purchase::where(['id'=>$request->purchase_id])->update(['account_id'=>$request->account_id]);

            if ($update) {
                $purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.id'=>$request->purchase_id])->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at')->first();
            }

            return response(['case' => 'success', 'purchase'=>$purchase]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //remove purchase from selected account
    public function remove_purchase_from_selected_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $update = Purchase::where(['id'=>$request->purchase_id])->update(['account_id'=>null]);

            if ($update) {
                $purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.id'=>$request->purchase_id])->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at')->first();
            }

            return response(['case' => 'success', 'purchase'=>$purchase]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
