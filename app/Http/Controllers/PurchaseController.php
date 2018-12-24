<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Deadlines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends HomeController
{
    //show
    public function get_purchases() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('companies as c', 'accounts.company_id', '=', 'c.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['Purchases.deleted'=>0, 'accounts.deleted'=>0 ,'o.deleted'=>0, 'Purchases.completed'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'users.name', 'users.surname', 'd.Department', 'o.deadline', 'Purchases.created_at', 'accounts.account_doc', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc')->paginate(30);

        $deadlines = Deadlines::where(['deleted'=>0])->select('type', 'deadline', 'color')->get();
        $current_date = Carbon::now()->format('Y-m-d');

        return view('backend.purchases')->with(['purchases'=>$purchases, 'deadlines'=>$deadlines, 'current_date'=>$current_date]);
    }

    //delete
    public function post_purchase_for_supply(Request $request) {
        if ($request->type == 'add_qaime') {
            return $this->add_qaime($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //add qaime
    public function add_qaime(Request $request) {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|integer',
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

            Purchase::where(['id'=>$request->purchase_id, 'deleted'=>0])->update(['qaime_no'=>$request->qaime_no, 'qaime_doc'=>$file_address, 'qaime_date'=>$current_date]);

            return response(['case' => 'success']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //for supply
    public function get_purchases_for_supply() {
        $deadlines = Deadlines::where(['deleted'=>0])->select('type', 'deadline', 'color')->get();
        $current_date = Carbon::now()->format('Y-m-d');

        if (Auth::user()->chief() == 1) {
            //supply chief
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('companies', 'accounts.company_id', '=', 'companies.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'Purchases.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.account_no', 'accounts.account_doc', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'companies.name as company', 'companies.address', 'companies.phone', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date')->paginate(30);
        }
        else {
            //supply user
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('companies', 'accounts.company_id', '=', 'companies.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'Purchases.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.account_no', 'accounts.account_doc', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'companies.name as company', 'companies.address', 'companies.phone', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date')->paginate(30);
        }

        return view('backend.purchases_for_supply')->with(['purchases'=>$purchases, 'deadlines'=>$deadlines, 'current_date'=>$current_date]);
    }
}
