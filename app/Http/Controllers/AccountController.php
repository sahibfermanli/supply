<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Company;
use App\Orders;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AccountController extends HomeController
{
    public function print_orders_in_account_for_supply() {
        $account_id = Input::get('a');

        if (empty($account_id)) {
            return redirect('/');
        }

        try {
            if (Auth::user()->chief() == 1) {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 's.status', 's.color', 'a.company_id', 'companies.name as company')->get();
            }
            else {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 's.status', 's.color', 'a.company_id', 'companies.name as company')->get();
            }

            return view('backend._print_orders_in_account')->with(['orders'=>$orders]);
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    public function get_accounts_for_supply() {
        $companies = Company::where(['deleted'=>0])->select('id', 'name')->orderBy('name')->get();
        $accounts = Accounts::where(['deleted'=>0])->select()->paginate(30);
        if (Auth::user()->chief() == 1) {
            $free_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->whereNull('account_id')->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 's.status', 's.color', 'a.company_id', 'companies.name as company')->get();
        }
        else {
            $free_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.SupplyID'=>Auth::id()])->whereNull('account_id')->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 's.status', 's.color', 'a.company_id', 'companies.name as company')->get();
        }

        return view('backend.accounts')->with(['accounts'=>$accounts, 'free_purchases'=>$free_purchases, 'companies'=>$companies]);
    }

    public function post_accounts_for_supply(Request $request) {
        if ($request->type == 'delete') {
            //delete
            if (Accounts::where(['id'=>$request->id, 'deleted'=>0, 'send'=>0])->count() > 0) {
                return $this->delete_account($request);
            }
            else {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
            }
        }
        else if ($request->type == 'add') {
            //add
            return $this->add_account($request);
        }
        else if ($request->type == 'update') {
            //update
            if (Accounts::where(['id'=>$request->id, 'deleted'=>0, 'send'=>0])->count() > 0) {
                return $this->update_account($request);
            }
            else {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
            }
        }
        else if ($request->type == 'update_doc') {
            //update document
            if (Accounts::where(['id'=>$request->id, 'deleted'=>0, 'send'=>0])->count() > 0) {
                return $this->update_document($request);
            }
            else {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
            }
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
        else if ($request->type == 'send_lawyer') {
            //send lawyer
            if(Auth::user()->chief() == 1) {
                return $this->send_lawyer($request);
            }
            else {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Bu əməliyyat üçün icazəniz yoxdur!']);
            }
        }
        else if ($request->type == 'show_remark') {
            //show lawyer remark
            return $this->show_remark($request);
        }
        else if ($request->type == 'clear_remark') {
            //clear lawyer remark
            return $this->clear_remark($request);
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
            $del = Accounts::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            if ($del) {
                Purchase::where(['account_id'=>$id, 'deleted'=>0])->update(['account_id'=>null]);
            }

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
                $selected_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$request->account_id])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 's.status', 's.color', 'a.company_id', 'companies.name as company')->get();
            }
            else {
                $selected_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$request->account_id, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 's.status', 's.color', 'a.company_id', 'companies.name as company')->get();
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
            'company_id' => 'required|integer',
            'purchase_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab və ya sifariş tapılmadı!']);
        }
        try {
            if (Accounts::where(['id'=>$request->account_id, 'deleted'=>0, 'send'=>0])->count() > 0) {
                if (Accounts::where(['id'=>$request->account_id, 'deleted'=>0, 'send'=>0, 'company_id'=>$request->company_id])->count() == 0) {
                    return response(['case' => 'error', 'type'=>'company_false']);
                }

                $update = Purchase::where(['id'=>$request->purchase_id])->update(['account_id'=>$request->account_id]);

                if ($update) {
                    $purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.id'=>$request->purchase_id])->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 's.status', 's.color', 'a.company_id', 'companies.name as company')->first();
                }
            }
            else {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
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
                $purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.id'=>$request->purchase_id])->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 's.status', 's.color', 'a.company_id', 'companies.name as company')->first();
            }

            return response(['case' => 'success', 'purchase'=>$purchase]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    public function send_lawyer(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
        }
        try {
            $id = $request->account_id;
            $current_date = Carbon::now();

            $update = Accounts::where(['id'=>$id])->update(['send'=>1, 'send_at'=>$current_date]);

            if ($update) {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->where(['Purchases.account_id'=>$id])->select('a.OrderID')->get();

                Orders::whereIn('id', $orders)->update(['situation_id'=>11]);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Hüquqa göndərildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    public function show_remark(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
        }
        try {
            $id = $request->id;

            $account = Accounts::where(['id'=>$id, 'deleted'=>0])->select('lawyer_remark')->first();

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'data' => $account['lawyer_remark']]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    public function clear_remark(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
        }
        try {
            $id = $request->id;

            Accounts::where(['id'=>$id, 'deleted'=>0])->update(['lawyer_remark'=>null]);

            return response(['case' => 'success', 'title' => 'Uğurlu!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
