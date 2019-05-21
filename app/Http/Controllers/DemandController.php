<?php

namespace App\Http\Controllers;

use App\Demands;
use App\OrderStatus;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DemandController extends HomeController
{
    //telebname
    public function print_orders_for_demand_for_supply() {
        $demand_id = Input::get('a');

        if (empty($demand_id)) {
            return redirect('/');
        }

        try {
            $demand = Demands::where(['id'=>$demand_id])->select('id')->first();

            $current_date = Carbon::now();
            $current_date = date('d M Y', strtotime($current_date));

            if (Auth::user()->chief() == 1) {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'o.DepartmentID', '=', 'd.id')->leftJoin('users as chief', 'o.ChiefID', '=', 'chief.id')->leftJoin('lb_vehicles_list as v', 'o.vehicle_id', '=', 'v.id')->leftJoin('users as director', 'Purchases.LawyerID', '=', 'director.id')->leftJoin('users as delivered', 'o.delivered_person', '=', 'delivered.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.demand_id'=>$demand_id])->orderBy('o.id')->select('o.id as id', 'a.Product', 'o.Translation_Brand', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'cur.cur_name as currency', 'o.Remark as order_remark', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as department', 'chief.name as chief_name', 'chief.surname as chief_surname', 'v.Marka', 'v.QN', 'v.Tipi', 'director.name as director_name', 'director.surname as director_surname', 'delivered.name as delivered_name', 'delivered.surname as delivered_surname')->get();
            }
            else {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_currencies_list as cur', 'a.currency_id', '=', 'cur.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'o.DepartmentID', '=', 'd.id')->leftJoin('users as chief', 'o.ChiefID', '=', 'chief.id')->leftJoin('lb_vehicles_list as v', 'o.vehicle_id', '=', 'v.id')->leftJoin('users as director', 'Purchases.LawyerID', '=', 'director.id')->leftJoin('users as delivered', 'o.delivered_person', '=', 'delivered.id')->where(['Purchases.deleted'=>0, 'Purchases.completed'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.demand_id'=>$demand_id, 'o.SupplyID'=>Auth::id()])->orderBy('o.id')->select('o.id as id', 'a.Product', 'o.Translation_Brand', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'cur.cur_name as currency', 'o.Remark as order_remark', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as department', 'chief.name as chief_name', 'chief.surname as chief_surname', 'v.Marka', 'v.QN', 'v.Tipi', 'director.name as director_name', 'director.surname as director_surname', 'delivered.name as delivered_name', 'delivered.surname as delivered_surname')->get();
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

            return view('backend._print_demand2')->with(['orders'=>$orders, 'demand'=>$demand, 'current_date'=>$current_date, 'cost_arr'=>$cost_arr]);
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    public function get_demand() {
        if (Auth::user()->chief() == 1) {
            $demands = Demands::leftJoin('users as u', 'demands.created_by', '=', 'u.id')->where(['demands.deleted'=>0])->select('demands.id', 'u.name', 'u.surname', 'demands.created_at')->paginate(30);
            $free_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->leftJoin('users', 'o.delivered_person', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->whereNotNull('o.delivered_person')->whereNull('Purchases.demand_id')->orderBy('o.id', 'ASC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.delivered_person', 'users.name as delivered_name', 'users.surname as delivered_surname')->get();
        }
        else {
            $demands = Demands::leftJoin('users as u', 'demands.created_by', '=', 'u.id')->where(['demands.deleted'=>0, 'created_by'=>Auth::id()])->select('demands.id', 'u.name', 'u.surname', 'demands.created_at')->paginate(30);
            $free_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->leftJoin('users', 'o.delivered_person', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.SupplyID'=>Auth::id()])->whereNotNull('o.delivered_person')->whereNull('Purchases.demand_id')->orderBy('o.id', 'ASC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.id as order_id', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.delivered_person', 'users.name as delivered_name', 'users.surname as delivered_surname')->get();
        }

        return view("backend.demands")->with(['demands'=>$demands, 'free_purchases'=>$free_purchases]);
    }

    public function post_demand(Request $request) {
        if ($request->type == 'delete') {
            //delete
            return $this->delete_demand($request);
        }
        else if ($request->type == 'add') {
            //add
            return $this->add_demand();
        }
        else if ($request->type == 'show_purchases') {
            //show selected purchases
            return $this->show_selected_purchases($request);
        }
        else if ($request->type == 'add_purchase_to_selected_demand') {
            //add purchase to selected demand
            return $this->add_purchase_to_selected_demand($request);
        }
        else if ($request->type == 'remove_purchase_from_selected_demand') {
            //remove purchase from selected demand
            return $this->remove_purchase_from_selected_demand($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Əməliyyat növü tapılmadı!']);
        }
    }

    //delete demand
    private function delete_demand(Request $request) {
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
            $del = Demands::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            if ($del) {
                Purchase::where(['demand_id'=>$id, 'deleted'=>0])->update(['demand_id'=>null]);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Silindi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Silinmə zamanı səhv baş verdi!']);
        }
    }

    //add demand
    private function add_demand() {
        try {
            Demands::create(['created_by'=>Auth::id()]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Tələbnamə əlavə edildi!', 'type' => 'add_demand']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //show purchases when clicked demand
    private function show_selected_purchases(Request $request) {
        $validator = Validator::make($request->all(), [
            'demand_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Tələbnamə tapılmadı!']);
        }
        try {
            if (Auth::user()->chief() == 1) {
                $selected_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->leftJoin('users', 'o.delivered_person', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.demand_id'=>$request->demand_id])->orderBy('o.id', 'ASC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.delivered_person', 'users.name as delivered_name', 'users.surname as delivered_surname')->get();
            }
            else {
                $selected_purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->leftJoin('users', 'o.delivered_person', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.demand_id'=>$request->demand_id, 'o.SupplyID'=>Auth::id()])->orderBy('o.id', 'ASC')->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.delivered_person', 'users.name as delivered_name', 'users.surname as delivered_surname')->get();
            }

            return response(['case' => 'success', 'selected_purchases'=>$selected_purchases]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //add purchase to selected demand
    private function add_purchase_to_selected_demand(Request $request) {
        $validator = Validator::make($request->all(), [
            'demand_id' => 'required|integer',
            'delivered_person' => 'required|integer',
            'order_id' => 'required|integer',
            'purchase_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            if (Purchase::where(['deleted'=>0, 'demand_id'=>$request->demand_id])->count() > 0) {
                $delivered_purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'Purchases.demand_id'=>$request->demand_id])->select('o.delivered_person')->first();
                $delivered_person = $delivered_purchase->delivered_person;

                if ($request->delivered_person != $delivered_person) {
                    return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Bir tələbnamədəki bütün təhvil alan şəxslər eyni olmalıdır!']);
                }
            }

            $update = Purchase::where(['id'=>$request->purchase_id])->update(['demand_id'=>$request->demand_id]);

            if ($update) {
                $status_arr['order_id'] = $request->order_id;
                $status_arr['status_id'] = 24; //telebname yaradildi
                OrderStatus::create($status_arr);

                $purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->leftJoin('users', 'o.delivered_person', '=', 'users.id')->where(['Purchases.id'=>$request->purchase_id])->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.delivered_person', 'users.name as delivered_name', 'users.surname as delivered_surname')->first();
            }

            return response(['case' => 'success', 'purchase'=>$purchase]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //remove purchase from selected account
    private function remove_purchase_from_selected_demand(Request $request) {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|integer',
            'order_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $update = Purchase::where(['id'=>$request->purchase_id])->update(['demand_id'=>null]);

            if ($update) {
                $purchase = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('lb_sellers', 'a.company_id', '=', 'lb_sellers.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('lb_status as status', 'o.last_status_id', '=', 'status.id')->leftJoin('users', 'o.delivered_person', '=', 'users.id')->where(['Purchases.id'=>$request->purchase_id])->select('Purchases.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.created_at', 'a.company_id', 'lb_sellers.seller_name as company', 'o.id as OrderID', 'o.last_status_id as status_id', 'status.status', 'status.color as status_color', 'o.delivered_person', 'users.name as delivered_name', 'users.surname as delivered_surname')->first();
            }

            return response(['case' => 'success', 'purchase'=>$purchase]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
