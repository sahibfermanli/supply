<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Company;
use App\Orders;
use App\OrderStatus;
use App\Purchase;
use App\Sellers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
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
            if (Purchase::where(['account_id'=>$account_id, 'deleted'=>0, 'completed'=>0])->count() == 0) {
                Session::flash('message', 'Bu hesabda heç bir sifariş tapılmadı!');
                Session::flash('class', 'danger');
                Session::flash('display', 'block');
                return redirect('/');
            }

            $account = Accounts::leftJoin('lb_sellers as s', 'accounts.company_id', '=', 's.id')->where(['accounts.id'=>$account_id])->select('accounts.account_no', 's.*')->first();

            $current_date = Carbon::now();
            $current_date = date('d M Y', strtotime($current_date));

            if (Auth::user()->authority() == 4)  {
                //supply
                if (Auth::user()->chief() == 1) {
                    $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'companies.name as company', 'cur.cur_name as currency')->get();
                }
                else {
                    $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'companies.name as company', 'cur.cur_name as currency')->get();
                }
            }
            else if (Auth::user()->authority() == 6) {
                //law
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'companies.name as company', 'cur.cur_name as currency')->get();
            }
            else if (Auth::user()->authority() == 7) {
                //finance
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'companies.name as company', 'cur.cur_name as currency')->get();
            }
            else if (Auth::user()->authority() == 5) {
                //director
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('companies', 'a.company_id', '=', 'companies.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'companies.name as company', 'cur.cur_name as currency')->get();
            }
            else {
                Session::flash('message', 'Bu səhifəyə giriş icazəniz yoxdur!');
                Session::flash('class', 'danger');
                Session::flash('display', 'block');
                return redirect('/');
            }

            if (count($orders) == 0) {
                Session::flash('message', 'Bu hesabda heç bir sifariş tapılmadı!');
                Session::flash('class', 'danger');
                Session::flash('display', 'block');
                return redirect('/');
            }

            return view('backend._print_orders_in_account')->with(['orders'=>$orders, 'account'=>$account, 'current_date'=>$current_date]);
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    //raport
    public function print_orders_for_finance_for_supply() {
        $account_id = Input::get('a');

        if (empty($account_id)) {
            return redirect('/');
        }

        try {
            if (Purchase::where(['account_id'=>$account_id, 'deleted'=>0, 'completed'=>0])->count() == 0) {
                Session::flash('message', 'Bu hesabda heç bir sifariş tapılmadı!');
                Session::flash('class', 'danger');
                Session::flash('display', 'block');
                return redirect('/');
            }

            $account = Accounts::leftJoin('lb_sellers as s', 'accounts.company_id', '=', 's.id')->where(['accounts.id'=>$account_id])->select('accounts.account_no', 's.*')->first();

            $current_date = Carbon::now();
            $current_date = date('d M Y', strtotime($current_date));

            if (Auth::user()->chief() == 1) {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'o.DepartmentID', '=', 'd.id')->leftJoin('users as chief', 'o.ChiefID', '=', 'chief.id')->leftJoin('lb_vehicles_list as v', 'o.vehicle_id', '=', 'v.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id])->orderBy('Purchases.id')->select('Purchases.id as id', 'a.Product', 'o.Translation_Brand', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'cur.cur_name as currency', 'o.Remark as order_remark', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as department', 'chief.name as chief_name', 'chief.surname as chief_surname', 'v.Marka', 'v.QN', 'v.Tipi')->get();
            }
            else {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'o.DepartmentID', '=', 'd.id')->leftJoin('users as chief', 'o.ChiefID', '=', 'chief.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id')->select('Purchases.id as id', 'a.Product', 'o.Translation_Brand', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'cur.cur_name as currency', 'o.Remark as order_remark', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as department', 'chief.name as chief_name', 'chief.surname as chief_surname')->get();
            }

            return view('backend._print_orders_for_finance')->with(['orders'=>$orders, 'account'=>$account, 'current_date'=>$current_date]);
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    //telebname
    public function print_orders_for_demand_for_supply() {
        $account_id = Input::get('a');

        if (empty($account_id)) {
            return redirect('/');
        }

        try {
//            if (Purchase::where(['account_id'=>$account_id, 'deleted'=>0, 'completed'=>0])->count() == 0) {
//                Session::flash('message', 'Bu hesabda heç bir sifariş tapılmadı!');
//                Session::flash('class', 'danger');
//                Session::flash('display', 'block');
//                return redirect('/');
//            }

            $account = Accounts::where(['id'=>$account_id])->select('account_no', 'id')->first();

            $current_date = Carbon::now();
            $current_date = date('d M Y', strtotime($current_date));

            if (Auth::user()->chief() == 1) {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'o.DepartmentID', '=', 'd.id')->leftJoin('users as chief', 'o.ChiefID', '=', 'chief.id')->leftJoin('lb_vehicles_list as v', 'o.vehicle_id', '=', 'v.id')->leftJoin('users as director', 'Purchases.LawyerID', '=', 'director.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id])->orderBy('Purchases.id')->select('o.id as id', 'a.Product', 'o.Translation_Brand', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'cur.cur_name as currency', 'o.Remark as order_remark', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as department', 'chief.name as chief_name', 'chief.surname as chief_surname', 'v.Marka', 'v.QN', 'v.Tipi', 'director.name as director_name', 'director.surname as director_surname')->get();
            }
            else {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'o.DepartmentID', '=', 'd.id')->leftJoin('users as chief', 'o.ChiefID', '=', 'chief.id')->leftJoin('users as director', 'Purchases.LawyerID', '=', 'director.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$account_id, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id')->select('o.id as id', 'a.Product', 'o.Translation_Brand', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'cur.cur_name as currency', 'o.Remark as order_remark', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as department', 'chief.name as chief_name', 'chief.surname as chief_surname', 'director.name as director_name', 'director.surname as director_surname')->get();
            }

            $cost_arr = array();
            foreach ($orders as $order) {
                if (isset($cost_arr[$order->currency])) {
                    $old_val = $cost_arr[$order->currency];
                    $new_val = $old_val + $order->total_cost;
                    $cost_arr[$order->currency] = $new_val;
                } else {
                    $new_val = $order->total_cost;
                    $cost_arr[$order->currency] = $new_val;
                }
            }

            return view('backend._print_demand')->with(['orders'=>$orders, 'account'=>$account, 'current_date'=>$current_date, 'cost_arr'=>$cost_arr]);
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    public function get_accounts_for_supply() {
        $companies = Sellers::where(['deleted'=>0])->select('id', 'seller_name')->orderBy('seller_name')->get();
        $accounts = Accounts::leftJoin('users as u', 'accounts.edited_by', '=', 'u.id')->where(['accounts.deleted'=>0])->select('accounts.*', 'u.name as edited_name', 'u.surname as edited_surname')->paginate(30);
        if (Auth::user()->chief() == 1) {
            $free_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->whereNull('account_id')->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->get();
        }
        else {
            $free_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.SupplyID'=>Auth::id()])->whereNull('account_id')->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->get();
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
        else if ($request->type == 'add_qaime') {
            return $this->add_qaime($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //add qaime
    private function add_qaime(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|integer',
            'qaime_no' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Lazımı xanaları doldurun!']);
        }
        try {
            $file = Input::file('file');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = 'qaime_' . str_random(4) . '_' . microtime() . '.' . $file_ext;
            Storage::disk('uploads')->makeDirectory('files/qaime');
            $file->move('uploads/files/qaime/', $file_name);
            $file_address = '/uploads/files/qaime/' . $file_name;

            $current_date = Carbon::now();

            Purchase::where(['account_id'=>$request->account_id, 'deleted'=>0])->update(['qaime_no'=>$request->qaime_no, 'qaime_doc'=>$file_address, 'qaime_date'=>$current_date]);

            return response(['case' => 'success']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //delete account
    private function delete_account(Request $request) {
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
    private function add_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_no' => 'required|string|max:50',
            'company_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Bütün xanaları doldurun!']);
        }
        try {
            $request->merge(['edited_by'=>Auth::id()]);

            Accounts::create($request->all());

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Hesab əlavə edildi!', 'type' => 'add_account']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //update account
    private function update_account(Request $request) {
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
    private function update_document(Request $request) {
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
    private function show_selected_purchases(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
        }
        try {
            if (Auth::user()->chief() == 1) {
                $selected_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$request->account_id])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->get();
            }
            else {
                $selected_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.account_id'=>$request->account_id, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->get();
            }

            return response(['case' => 'success', 'selected_purchases'=>$selected_purchases]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //add purchase to selected account
    private function add_purchase_to_selected_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|integer',
            'company_id' => 'required|integer',
            'order_id' => 'required|integer',
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
//                    Orders::where(['id'=>$request->order_id])->update(['situation_id'=>20]); //hesaba elave edildi
                    $status_arr['order_id'] = $request->order_id;
                    $status_arr['status_id'] = 20; //hesaba elave edildi
                    OrderStatus::create($status_arr);

                    $purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.id'=>$request->purchase_id])->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->first();
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
    private function remove_purchase_from_selected_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|integer',
            'order_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $update = Purchase::where(['id'=>$request->purchase_id])->update(['account_id'=>null]);

            if ($update) {
//                Orders::where(['id'=>$request->order_id])->update(['situation_id'=>5]); //alimlara elave edildi (hesabdan cixarilanda)
                $status_arr['order_id'] = $request->order_id;
                $status_arr['status_id'] = 5; //alimlara elave edildi (hesabdan cixarilanda)
                OrderStatus::create($status_arr);

                $purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.id'=>$request->purchase_id])->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->first();
            }

            return response(['case' => 'success', 'purchase'=>$purchase]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    private function send_lawyer(Request $request) {
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

//                Orders::whereIn('id', $orders)->update(['situation_id'=>11]);
                $status_arr['status_id'] = 11;
                foreach ($orders as $order) {
                    $status_arr['order_id'] = $order->OrderID;
                    OrderStatus::create($status_arr);
                }
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Hüquqa göndərildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    private function show_remark(Request $request) {
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

    private function clear_remark(Request $request) {
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
