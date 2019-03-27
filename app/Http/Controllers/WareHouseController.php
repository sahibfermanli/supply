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

class WareHouseController extends HomeController
{
    //for supply
    public function get_warehouse_for_supply() {
        if (Auth::user()->chief() == 1) {
            //supply chief
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users as wh', 'o.delivered_person', '=', 'wh.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>0])->whereNotNull('o.delivered_person')->orderBy('o.id', 'DESC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'wh.name as wh_name', 'wh.surname as wh_surname')->paginate(30);
        }
        else {
            //supply user->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users as wh', 'o.delivered_person', '=', 'wh.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>0, 'o.SupplyID'=>Auth::id()])->whereNotNull('o.delivered_person')->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'wh.name as wh_name', 'wh.surname as wh_surname')->paginate(30);
        }

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.warehouse')->with(['purchases'=>$purchases]);
    }

    //for director
    public function get_warehouse_for_director() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users as wh', 'o.delivered_person', '=', 'wh.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>0])->whereNotNull('o.delivered_person')->orderBy('o.id', 'DESC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'wh.name as wh_name', 'wh.surname as wh_surname')->paginate(30);

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.warehouse')->with(['purchases'=>$purchases]);
    }

    //for users
    public function get_warehouse_for_users() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users as wh', 'o.delivered_person', '=', 'wh.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>0, 'o.MainPerson'=>Auth::id()])->whereNotNull('o.delivered_person')->orderBy('o.id', 'DESC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'wh.name as wh_name', 'wh.surname as wh_surname')->paginate(30);

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.warehouse')->with(['purchases'=>$purchases]);
    }

    //for chief
    public function get_warehouse_for_chief() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users as wh', 'o.delivered_person', '=', 'wh.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>0, 'o.DepartmentID'=>Auth::user()->DepartmentID()])->whereNotNull('o.delivered_person')->orderBy('o.id', 'DESC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'wh.name as wh_name', 'wh.surname as wh_surname')->paginate(30);

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.warehouse')->with(['purchases'=>$purchases]);
    }

    //for warehouseman
    public function get_warehouse_for_warehouseman() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>0, 'o.delivered_person'=>Auth::id()])->orderBy('o.id', 'DESC')->select('Purchases.id as id', 'a.Product', 'o.MainPerson', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id')->paginate(30);

        //get last status
        foreach ($purchases as $purchase) {
            $order_id = $purchase->order_id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $purchase['last_status'] = $statuses;
        }

        return view('backend.warehouse_for_warehouseman')->with(['purchases'=>$purchases]);
    }

    public function post_warehouse(Request $request) {
        if ($request->type == 'show_status') {
            return $this->show_status($request);
        }
        else if ($request->type == 'delivery_order') {
            return $this->delivery_order($request);
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

    //delivery order
    private function delivery_order(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();

            Orders::where(['id'=>$id])->update(['delivered'=>1, 'delivered_at'=>$date]);

            $status_arr['order_id'] = $id;
            $status_arr['status_id'] = 22; //sifariş təhvil verildi
            OrderStatus::create($status_arr);

            if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email = $user['email'];
                $to = $user['name'] . ' ' . $user['surname'];
                $message = $user['name'] . " " . $user['surname'] . ",
                            sizin '" . $user['Product'] . "' adlı sifarişiniz təslim edilmişdir.";
                $title = "Sifarişin təhvil verilməsi";

                app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Alternativ silindi!', 'row_id' => $id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
        }
    }
}
