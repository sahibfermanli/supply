<?php

namespace App\Http\Controllers;

use App\Departments;
use App\Orders;
use App\OrderStatus;
use App\Purchase;
use App\Sellers;
use App\Settings;
use App\Situations;
use App\User;
use App\Vehicles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends HomeController
{
    //delivered orders for supply
    public function get_delivered_for_supply() {
        //for search
        $departments = Departments::where(['deleted'=>0])->orderBy('Department')->select('id', 'Department')->get();
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        $sellers = Sellers::where(['deleted'=>0])->orderBy('seller_name')->select('id', 'seller_name as seller')->get();
        $warehousemen = User::where(['delivered_person'=>1, 'deleted'=>0])->select('id', 'name', 'surname')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        //

        $where_product = '';
        $where_brand = '';
        $where_model = '';
        $where_category_id = 0;
        $where_warehouseman_id = 0;
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
            'warehouseman' => '',
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

        if (!empty(Input::get('warehouseman')) && Input::get('warehouseman') != ''  && Input::get('warehouseman') != null) {
            $where_warehouseman_id = Input::get('warehouseman');
            $where_arr['o.delivered_person'] = $where_warehouseman_id;
            $search_arr['warehouseman'] = $where_warehouseman_id;
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

        if (Auth::user()->chief() == 1) {
            //supply chief
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1])->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->paginate(30);
        }
        else {
            //supply user->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.SupplyID'=>Auth::id()])->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->paginate(30);
        }

        return view('backend.delivered_orders')->with(['purchases'=>$purchases, 'departments'=>$departments, 'statuses'=>$situations, 'sellers'=>$sellers, 'warehousemen'=>$warehousemen, 'vehicles'=>$vehicles, 'search_arr'=>$search_arr]);
    }

    //delivered orders for director
    public function get_delivered_for_director() {
        //for search
        $departments = Departments::where(['deleted'=>0])->orderBy('Department')->select('id', 'Department')->get();
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        $sellers = Sellers::where(['deleted'=>0])->orderBy('seller_name')->select('id', 'seller_name as seller')->get();
        $warehousemen = User::where(['delivered_person'=>1, 'deleted'=>0])->select('id', 'name', 'surname')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        //

        $where_product = '';
        $where_brand = '';
        $where_model = '';
        $where_category_id = 0;
        $where_warehouseman_id = 0;
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
            'warehouseman' => '',
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

        if (!empty(Input::get('warehouseman')) && Input::get('warehouseman') != ''  && Input::get('warehouseman') != null) {
            $where_warehouseman_id = Input::get('warehouseman');
            $where_arr['o.delivered_person'] = $where_warehouseman_id;
            $search_arr['warehouseman'] = $where_warehouseman_id;
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

        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1])->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->paginate(30);

        return view('backend.delivered_orders')->with(['purchases'=>$purchases, 'departments'=>$departments, 'statuses'=>$situations, 'sellers'=>$sellers, 'warehousemen'=>$warehousemen, 'vehicles'=>$vehicles, 'search_arr'=>$search_arr]);
    }

    //delivered orders for users
    public function get_delivered_for_users() {
        //for search
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        $sellers = Sellers::where(['deleted'=>0])->orderBy('seller_name')->select('id', 'seller_name as seller')->get();
        $warehousemen = User::where(['delivered_person'=>1, 'deleted'=>0])->select('id', 'name', 'surname')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        //

        $where_product = '';
        $where_brand = '';
        $where_model = '';
        $where_category_id = 0;
        $where_warehouseman_id = 0;
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
            'warehouseman' => '',
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

        if (!empty(Input::get('warehouseman')) && Input::get('warehouseman') != ''  && Input::get('warehouseman') != null) {
            $where_warehouseman_id = Input::get('warehouseman');
            $where_arr['o.delivered_person'] = $where_warehouseman_id;
            $search_arr['warehouseman'] = $where_warehouseman_id;
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

        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.MainPerson'=>Auth::id()])->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->paginate(30);

        return view('backend.delivered_orders')->with(['purchases'=>$purchases, 'statuses'=>$situations, 'sellers'=>$sellers, 'warehousemen'=>$warehousemen, 'vehicles'=>$vehicles, 'search_arr'=>$search_arr]);
    }

    //delivered orders for chief
    public function get_delivered_for_chief() {
        //for search
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        $sellers = Sellers::where(['deleted'=>0])->orderBy('seller_name')->select('id', 'seller_name as seller')->get();
        $warehousemen = User::where(['delivered_person'=>1, 'deleted'=>0])->select('id', 'name', 'surname')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        //

        $where_product = '';
        $where_brand = '';
        $where_model = '';
        $where_category_id = 0;
        $where_warehouseman_id = 0;
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
            'warehouseman' => '',
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

        if (!empty(Input::get('warehouseman')) && Input::get('warehouseman') != ''  && Input::get('warehouseman') != null) {
            $where_warehouseman_id = Input::get('warehouseman');
            $where_arr['o.delivered_person'] = $where_warehouseman_id;
            $search_arr['warehouseman'] = $where_warehouseman_id;
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

        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.DepartmentID'=>Auth::user()->DepartmentID()])->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->paginate(30);

        return view('backend.delivered_orders')->with(['purchases'=>$purchases, 'statuses'=>$situations, 'sellers'=>$sellers, 'warehousemen'=>$warehousemen, 'vehicles'=>$vehicles, 'search_arr'=>$search_arr]);
    }

    //delivered orders for warehouseman
    public function get_delivered_for_warehouseman() {
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

        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'o.SupplyID', '=', 'supply.id')->leftJoin('users as lawyer', 'Purchases.LawyerID', '=', 'lawyer.id')->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.delivered_person'=>Auth::id()])->where('a.Product', 'like', '%'.$where_product.'%')->where('a.Brend', 'like', '%'.$where_brand.'%')->where('a.Model', 'like', '%'.$where_model.'%')->where($where_arr)->where('a.total_cost', '>=', $where_min_cost)->where('a.total_cost', '<=', $where_max_cost)->where('o.created_at', '>=', $where_start_date)->where('o.created_at', '<=', $where_end_date)->orderBy('o.id', 'DESC ')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.Remark', 'o.deadline', 'o.created_at', 'users.name', 'users.surname', 'd.Department', 'accounts.id as account_id', 'lb_sellers.seller_name', 'accounts.account_no', 'accounts.created_at as account_date', 'accounts.lawyer_doc', 'accounts.lawyer_confirm_at', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date', 'supply.name as supply_name', 'supply.surname as supply_surname', 'a.created_at as supply_date', 'lawyer.name as lawyer_name', 'lawyer.surname as lawyer_surname', 'Purchases.created_at as lawyer_date', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color')->paginate(30);

        return view('backend.delivered_orders')->with(['purchases'=>$purchases, 'departments'=>$departments, 'statuses'=>$situations, 'sellers'=>$sellers, 'vehicles'=>$vehicles, 'search_arr'=>$search_arr]);
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
