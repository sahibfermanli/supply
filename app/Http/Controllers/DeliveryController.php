<?php

namespace App\Http\Controllers;

use App\Orders;
use App\OrderStatus;
use App\Purchase;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends HomeController
{
    //delivered orders for supply
    public function get_delivered_for_supply() {
        if (Auth::user()->chief() == 1) {
            //supply chief
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1])->orderBy('o.id', 'DESC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id')->paginate(30);
        }
        else {
            //supply user->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.SupplyID'=>Auth::id()])->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id')->paginate(30);
        }

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.delivered_orders')->with(['purchases'=>$purchases]);
    }

    //delivered orders for director
    public function get_delivered_for_director() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1])->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id')->paginate(30);

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.delivered_orders')->with(['purchases'=>$purchases]);
    }

    //delivered orders for users
    public function get_delivered_for_users() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.MainPerson'=>Auth::id()])->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id')->paginate(30);

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.delivered_orders')->with(['purchases'=>$purchases]);
    }

    //delivered orders for chief
    public function get_delivered_for_chief() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.DepartmentID'=>Auth::user()->DepartmentID()])->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id')->paginate(30);

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.delivered_orders')->with(['purchases'=>$purchases]);
    }

    //delivered orders for warehouseman
    public function get_delivered_for_warehouseman() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.delivered_person'=>Auth::id()])->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id')->paginate(30);

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.delivered_orders')->with(['purchases'=>$purchases]);
    }

    public function post_delivered(Request $request) {
        if ($request->type == 'show_status') {
            return $this->show_status($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //show status (send order_id)
    private function show_status(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $order_id = $request->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id')->get();

            return response(['case' => 'success', 'statuses'=>$statuses]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
