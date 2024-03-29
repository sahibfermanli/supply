<?php

namespace App\Http\Controllers;

use App\Alternatives;
use App\Departments;
use App\Orders;
use App\OrderStatus;
use App\Purchase;
use App\Deadlines;
use App\Sellers;
use App\Settings;
use App\Situations;
use App\User;
use App\Vehicles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends HomeController
{
    //for director
    public function get_purchases() {
        //for search
        $departments = Departments::where(['deleted'=>0])->orderBy('Department')->select('id', 'Department')->get();
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        $sellers = Sellers::where(['deleted'=>0])->orderBy('seller_name')->select('id', 'seller_name as seller')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        //

        $where_product = '';
        $where_brand = '';
        $where_model = '';
        $where_category_id = 0;
        $where_department_id = 0;
        $where_vehicle_id = 0;
        $where_status_id = 0;
        $is_status_search = false;
        $where_seller_id = 0;
        $where_min_cost = 0;
        $where_max_cost = 10000000000000;
        $where_start_date = '1900-01-01 00:00:00';
        $where_end_date = Carbon::now();

        $where_arr = array();
        $search_arr = array(
            'product' => '',
            'brand' => '',
            'model' => '',
            'category' => '',
            'department' => '',
            'vehicle' => '',
            'status' => '',
            'seller' => '',
            'min_cost' => '',
            'max_cost' => '',
            'start_date' => '',
            'end_date' => ''
        );

        if (!empty(Input::get('product')) && Input::get('product') != ''  && Input::get('product') != null) {
            $where_product = Input::get('product');
            $search_arr['product'] = $where_product;
        }

        if (!empty(Input::get('brand')) && Input::get('brand') != ''  && Input::get('brand') != null) {
            $where_brand = Input::get('brand');
            $search_arr['brand'] = $where_brand;
        }

        if (!empty(Input::get('model')) && Input::get('model') != ''  && Input::get('model') != null) {
            $where_model = Input::get('model');
            $search_arr['model'] = $where_model;
        }

        if (!empty(Input::get('category')) && Input::get('category') != ''  && Input::get('category') != null) {
            $where_category_id = Input::get('category');
            $where_arr['o.category_id'] = $where_category_id;
            $search_arr['category'] = $where_category_id;
        }

        if (!empty(Input::get('department')) && Input::get('department') != ''  && Input::get('department') != null) {
            $where_department_id = Input::get('department');
            $where_arr['o.DepartmentID'] = $where_department_id;
            $search_arr['department'] = $where_department_id;
        }

        if (!empty(Input::get('vehicle')) && Input::get('vehicle') != ''  && Input::get('vehicle') != null) {
            $where_vehicle_id = Input::get('vehicle');
            $where_arr['o.vehicle_id'] = $where_vehicle_id;
            $search_arr['vehicle'] = $where_vehicle_id;
        }

        if (!empty(Input::get('status')) && Input::get('status') != ''  && Input::get('status') != null) {
            $where_status_id = Input::get('status');
            $where_arr['o.last_status_id'] = $where_status_id;
            $search_arr['status'] = $where_status_id;
        }

        if (!empty(Input::get('seller')) && Input::get('seller') != ''  && Input::get('seller') != null) {
            $where_seller_id = Input::get('seller');
            $where_arr['a.company_id'] = $where_seller_id;
            $search_arr['seller'] = $where_seller_id;
        }

        if (!empty(Input::get('min_cost')) && Input::get('min_cost') != ''  && Input::get('min_cost') != null) {
            $where_min_cost = Input::get('min_cost');
            $search_arr['min_cost'] = $where_min_cost;
        }

        if (!empty(Input::get('max_cost')) && Input::get('max_cost') != ''  && Input::get('max_cost') != null) {
            $where_max_cost = Input::get('max_cost');
            $search_arr['max_cost'] = $where_max_cost;
        }

        if (!empty(Input::get('start_date')) && Input::get('start_date') != ''  && Input::get('start_date') != null) {
            $where_start_date = Input::get('start_date');
            $search_arr['start_date'] = $where_start_date;
        }

        if (!empty(Input::get('end_date')) && Input::get('end_date') != ''  && Input::get('end_date') != null) {
            $where_end_date = Input::get('end_date');
            $search_arr['end_date'] = $where_end_date;
        }

        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->whereNull('o.delivered_person')->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.PartSerialNo', 'a.Remark as a_Remark', 'a.image', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.Remark as order_remark')->paginate(30);
        $deadlines = Deadlines::where(['deleted'=>0])->select('type', 'deadline', 'color')->get();
        $current_date = Carbon::now()->format('Y-m-d');

        return view('backend.purchases')->with(['purchases'=>$purchases, 'deadlines'=>$deadlines, 'current_date'=>$current_date, 'departments'=>$departments, 'statuses'=>$situations, 'sellers'=>$sellers, 'vehicles'=>$vehicles, 'search_arr'=>$search_arr]);
    }

    //for supply
    public function get_purchases_for_supply() {
        //for search
        $departments = Departments::where(['deleted'=>0])->orderBy('Department')->select('id', 'Department')->get();
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        $sellers = Sellers::where(['deleted'=>0])->orderBy('seller_name')->select('id', 'seller_name as seller')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        //

        $where_product = '';
        $where_brand = '';
        $where_model = '';
        $where_category_id = 0;
        $where_department_id = 0;
        $where_vehicle_id = 0;
        $where_status_id = 0;
        $is_status_search = false;
        $where_seller_id = 0;
        $where_min_cost = 0;
        $where_max_cost = 10000000000000;
        $where_start_date = '1900-01-01 00:00:00';
        $where_end_date = Carbon::now();

        $where_arr = array();
        $search_arr = array(
            'product' => '',
            'brand' => '',
            'model' => '',
            'category' => '',
            'department' => '',
            'vehicle' => '',
            'status' => '',
            'seller' => '',
            'min_cost' => '',
            'max_cost' => '',
            'start_date' => '',
            'end_date' => ''
        );

        if (!empty(Input::get('product')) && Input::get('product') != ''  && Input::get('product') != null) {
            $where_product = Input::get('product');
            $search_arr['product'] = $where_product;
        }

        if (!empty(Input::get('brand')) && Input::get('brand') != ''  && Input::get('brand') != null) {
            $where_brand = Input::get('brand');
            $search_arr['brand'] = $where_brand;
        }

        if (!empty(Input::get('model')) && Input::get('model') != ''  && Input::get('model') != null) {
            $where_model = Input::get('model');
            $search_arr['model'] = $where_model;
        }

        if (!empty(Input::get('category')) && Input::get('category') != ''  && Input::get('category') != null) {
            $where_category_id = Input::get('category');
            $where_arr['o.category_id'] = $where_category_id;
            $search_arr['category'] = $where_category_id;
        }

        if (!empty(Input::get('department')) && Input::get('department') != ''  && Input::get('department') != null) {
            $where_department_id = Input::get('department');
            $where_arr['o.DepartmentID'] = $where_department_id;
            $search_arr['department'] = $where_department_id;
        }

        if (!empty(Input::get('vehicle')) && Input::get('vehicle') != ''  && Input::get('vehicle') != null) {
            $where_vehicle_id = Input::get('vehicle');
            $where_arr['o.vehicle_id'] = $where_vehicle_id;
            $search_arr['vehicle'] = $where_vehicle_id;
        }

        if (!empty(Input::get('status')) && Input::get('status') != ''  && Input::get('status') != null) {
            $where_status_id = Input::get('status');
            $where_arr['o.last_status_id'] = $where_status_id;
            $search_arr['status'] = $where_status_id;
        }

        if (!empty(Input::get('seller')) && Input::get('seller') != ''  && Input::get('seller') != null) {
            $where_seller_id = Input::get('seller');
            $where_arr['a.company_id'] = $where_seller_id;
            $search_arr['seller'] = $where_seller_id;
        }

        if (!empty(Input::get('min_cost')) && Input::get('min_cost') != ''  && Input::get('min_cost') != null) {
            $where_min_cost = Input::get('min_cost');
            $search_arr['min_cost'] = $where_min_cost;
        }

        if (!empty(Input::get('max_cost')) && Input::get('max_cost') != ''  && Input::get('max_cost') != null) {
            $where_max_cost = Input::get('max_cost');
            $search_arr['max_cost'] = $where_max_cost;
        }

        if (!empty(Input::get('start_date')) && Input::get('start_date') != ''  && Input::get('start_date') != null) {
            $where_start_date = Input::get('start_date');
            $search_arr['start_date'] = $where_start_date;
        }

        if (!empty(Input::get('end_date')) && Input::get('end_date') != ''  && Input::get('end_date') != null) {
            $where_end_date = Input::get('end_date');
            $search_arr['end_date'] = $where_end_date;
        }

        $deadlines = Deadlines::where(['deleted'=>0])->select('type', 'deadline', 'color')->get();
        $current_date = Carbon::now()->format('Y-m-d');
        $delivered_persons = User::where(['delivered_person'=>1, 'deleted'=>0])->select('id', 'name', 'surname')->get();

        if (Auth::user()->chief() == 1) {
            //supply chief
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->whereNull('o.delivered_person')->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.PartSerialNo', 'a.Remark as a_Remark', 'a.image', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.MainPerson', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.Remark as order_remark')->paginate(30);
        }
        else {
            //supply user
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.SupplyID'=>Auth::id()])->whereNull('o.delivered_person')->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.PartSerialNo', 'a.Remark as a_Remark', 'a.image', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.MainPerson', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.Remark as order_remark')->paginate(30);
        }

        return view('backend.purchases_for_supply')->with(['purchases'=>$purchases, 'deadlines'=>$deadlines, 'current_date'=>$current_date, 'delivered_persons'=>$delivered_persons, 'departments'=>$departments, 'statuses'=>$situations, 'sellers'=>$sellers, 'vehicles'=>$vehicles, 'search_arr'=>$search_arr]);
    }

    //post
    public function post_purchases(Request $request) {
        if ($request->type == 'show_status') {
            return $this->show_status($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //post for supply
    public function post_purchase_for_supply(Request $request) {
        if ($request->type == 'add_qaime') {
            return $this->add_qaime($request);
        }
        else if ($request->type == 'show_status') {
            return $this->show_status($request);
        }
//        else if ($request->type == 'get_order_for_delivery') {
//            return $this->get_order_for_delivery($request);
//        }
        else if ($request->type == 'order_delivered') {
            return $this->order_delivered($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //get order for delivery
    private function get_order_for_delivery(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $order_id = $request->order_id;

            $order = Orders::where(['id'=>$order_id])->select('id', 'Pcs as count')->first();

            return response(['case' => 'success', 'order'=>$order]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //order delivered submit
    private function order_delivered(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'count' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $order_id = $request->order_id;
            $user_id = $request->user_id;
            $count = $request->count;

            $warehouseman_mail = false;

            if (User::where(['id'=>$user_id, 'delivered_person'=>1])->count() > 0) {
                //ware house man
                $delivery = Orders::where(['id'=>$order_id])->update(['delivered_person'=>$user_id]);
                $status_id = 21; //anbara daxil oldu
                $message = "anbardara verilmişdir";
                $title = "Sifarişin anbara daxil olması";

                $warehouseman_mail = true;
            }
            else {
                //main person
                $delivery = Orders::where(['id'=>$order_id])->update(['delivered_person'=>$user_id, 'delivered'=>1]);
                $status_id = 22; //sifariş təhvil verildi
                $message = "təslim edilmişdir";
                $title = "Sifarişin təhvil verilməsi";
            }

            if ($delivery) {
                $order = Orders::where(['id'=>$order_id])->select('*')->first();
                $old_pcs = $order->Pcs;

                if ($count < $old_pcs) {
                    $new_order = array();
                    //qaliq sifarisi yeni kimi yaz (residual)
                    Orders::where(['id'=>$order_id])->update(['Pcs'=>$count]);
                    Alternatives::where(['OrderID'=>$order_id])->update(['pcs'=>$count]);
                    $new_pcs = $old_pcs - $count;

                    $new_order['Product'] = $order->Product;
                    $new_order['Translation_Brand'] = $order->Translation_Brand;
                    $new_order['Part'] = $order->Part;
                    $new_order['WEB_link'] = $order->WEB_link;
                    $new_order['image'] = $order->image;
                    $new_order['unit_id'] = $order->unit_id;
                    $new_order['Remark'] = $order->Remark;
                    $new_order['MainPerson'] = $order->MainPerson;
                    $new_order['DepartmentID'] = $order->DepartmentID;
                    $new_order['category_id'] = $order->category_id;
                    $new_order['vehicle_id'] = $order->vehicle_id;
                    $new_order['position_id'] = $order->position_id;
                    $new_order['deffect_doc'] = $order->deffect_doc;
                    $new_order['Pcs'] = $new_pcs;
                    $new_order['SupplyID'] = $order->SupplyID;
                    $new_order['deadline'] = $order->deadline;
                    $new_order['confirmed'] = $order->confirmed;
                    $new_order['confirmed_at'] = $order->confirmed_at;
                    $new_order['ChiefID'] = $order->ChiefID;
                    $new_order['residual'] = $order->id;

                    Orders::create($new_order);

                    $message .= ". Sifarişin qalıq hissəsi yeni sifariş kimi sistemə daxil edilmişdir";
                }

                $status_arr['order_id'] = $order_id;
                $status_arr['status_id'] = $status_id;
                OrderStatus::create($status_arr);

                if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                            sizin '" . $user['Product'] . "' adlı sifarişiniz " . $message . ".";

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);

                    if ($warehouseman_mail) {
                        $wharehouseman = User::where(['id'=>$user_id])->select('name', 'surname', 'email')->first();

                        $email = $wharehouseman['email'];
                        $to = $wharehouseman['name'] . ' ' . $wharehouseman['surname'];
                        $message = $wharehouseman['name'] . " " . $wharehouseman['surname'] . ",
                            '" . $user['Product'] . "' adlı yeni məhsul anbara daxil oldu.";

                        app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                    }
                }
            }

            return response(['case' => 'success', 'title'=>'Uğurlu!', 'content'=>'Uğurlu!', 'type'=>'delivered_person']);
        } catch (\Exception $e) {
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

    //add qaime
    private function add_qaime(Request $request) {
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
}
