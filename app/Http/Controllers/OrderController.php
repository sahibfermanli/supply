<?php

namespace App\Http\Controllers;

use App\Alternatives;
use App\Categories;
use App\Company;
use App\Countries;
use App\Currencies;
use App\Departments;
use App\Orders;
use App\OrderStatus;
use App\Positions;
use App\Sellers;
use App\Settings;
use App\Situations;
use App\Units;
use App\User;
use App\Vehicles;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Image;

class OrderController extends HomeController
{
    //user
    //get orders
    public function get_orders()
    {
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

        //for search
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        //

        return view('backend.orders')->with(['units' => $units, 'vehicles' => $vehicles, 'positions' => $positions, 'statuses'=>$situations]);
    }

    //post order for user
    public function post_delete_order(Request $request)
    {
        if ($request->type == 1) {
            //delete
            return $this->delete_order($request);
        } else if ($request->type == 2) {
            //show orders
            return $this->show_orders_for_users($request);
        } else if ($request->type == 3) {
            //get remark
            return $this->get_remark($request);
        } else if ($request->type == 4) {
            //get image
            return $this->get_image($request);
        }
        else if ($request->type == 5) {
            //add new order
            return $this->add_order($request);
        }
        else if ($request->type == 6) {
            //update order
            return $this->update_order($request);
        }
        else if ($request->type == 'update_remark') {
            //update remark
            return $this->update_remark($request);
        }
        else if ($request->type == 'show_status') {
            return $this->show_status($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //chief
    //get orders for chiefs
    public function get_orders_for_chief()
    {
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

        //for search
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        //

        return view('backend.orders_for_chief')->with(['units' => $units, 'vehicles' => $vehicles, 'positions' => $positions, 'statuses'=>$situations]);
    }

    //post order for chief
    public function post_delete_order_for_chief(Request $request)
    {
        if ($request->type == 1) {
            //cancel
            return $this->cancel_order_for_chief($request);
        } else if ($request->type == 2) {
            //show orders
            return $this->show_orders_for_chief($request);
        } else if ($request->type == 3) {
            //get remark
            return $this->get_remark($request);
        } else if ($request->type == 4) {
            //get image
            return $this->get_image($request);
        }
        else if ($request->type == 5) {
            //add new order
            return $this->add_order($request);
        }
        else if ($request->type == 6) {
            //update order
            return $this->update_order($request);
        }
        else if ($request->type == 7) {
            //confirm order
            return $this->confirm_order($request);
        }
        else if ($request->type == 'update_remark') {
            //update remark
            return $this->update_remark($request);
        }
        else if ($request->type == 'show_status') {
            return $this->show_status($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //supply
    //orders for supply
    public function get_orders_for_supply()
    {
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();
        $countries = Countries::where('deleted', 0)->select(['id', 'country_code', 'country_name'])->get();
        $currencies = Currencies::where('deleted', 0)->select(['id', 'cur_name', 'cur_value', 'cur_rate'])->get();
        $companies = Sellers::where(['deleted'=>0])->select('id', 'seller_name as name')->orderBy('seller_name')->get();
        $supplies = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['d.authority_id'=>4, 'users.deleted'=>0])->select('users.id', 'users.name', 'users.surname')->get();

        //for search
        $departments = Departments::where(['deleted'=>0])->orderBy('Department')->select('id', 'Department')->get();
        $situations = Situations::where(['deleted'=>0])->orderBy('status')->select('id', 'status')->get();
        //

        return view('backend.orders_for_supply')->with(['units' => $units, 'companies'=>$companies, 'vehicles' => $vehicles, 'positions' => $positions, 'countries'=>$countries, 'currencies'=>$currencies, 'supplies'=>$supplies, 'departments'=>$departments, 'statuses'=>$situations]);
    }

    //post order for supply
    public function post_delete_order_for_supply(Request $request)
    {
        if ($request->type == 1) {
            //cancel
            return $this->cancel_order_for_supply($request);
        } else if ($request->type == 2) {
            //empty
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Error!']);
        } else if ($request->type == 3) {
            //get remark
            return $this->get_remark($request);
        } else if ($request->type == 4) {
            //get image
            return $this->get_image($request);
        } else if ($request->type == 5) {
            //create alternative
            return $this->create_alternative($request);
        }
        else if ($request->type == 6) {
            //show orders
            return $this->show_orders_for_supply($request);
        }
        else if ($request->type == 7) {
            //add new order
            return $this->add_order($request);
        }
        else if ($request->type == 8) {
            //show alternative
            return $this->show_alternative($request);
        }
        else if ($request->type == 9) {
            //select supply for order
            return $this->select_supply_for_order($request);
        }
        else if ($request->type == 10) {
            if (Auth::user()->chief() == 0) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sizin bu əməliyyat üçün hüququnuz yoxdur!']);
            }
            //confirm alternative for chief supply
            return $this->confirm_alternative_for_supply_chief($request);
        }
        else if ($request->type == 11 && Auth::user()->chief() == 1) {
            //confirm order for chief
            return $this->confirm_order($request);
        }
        else if ($request->type == 12) {
            //update order
            return $this->update_order($request);
        }
        else if ($request->type == 13) {
            //update order image
            return $this->update_order_image($request);
        }
        else if ($request->type == 14) {
            //get alternative image
            return $this->get_alt_image($request);
        }
        else if ($request->type == 15) {
            //delete alternative
            return $this->delete_alternative($request);
        }
        else if ($request->type == 16) {
            //suggestion alternative
            return $this->suggestion_alternative($request);
        }
        else if ($request->type == 'show_status') {
            return $this->show_status($request);
        }
        else if ($request->type == 'back_order') {
            return $this->back_order($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Error!']);
        }
    }


    //private functions

    //back_order
    private function back_order(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadl!']);
        }
        try {
            $id = $request->id;
            $status_arr['order_id'] = $id;
            $status_arr['status_id'] = 23; //sifarisciye geri gonderildi
            $back_order = Orders::where(['id'=>$id])->update(['confirmed'=>0, 'ChiefID'=>null, 'SupplyID'=>null]);

            if ($back_order) {
                OrderStatus::create($status_arr);
                if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                            sizin <b>" . $user['Product'] . "</b> adlı sifarişiniz təchizatçı (" . Auth::user()->name . " " . Auth::user()->surname . ") tərəfindən sizə geri göndərildi. Siz sifarişi silə və ya düzəliş edib yenidən göndərə bilərsiniz. Yenidən göndərsəniz departament rəhbəriniz sifarişi bir daha təsdiq etməlidir.";
                    $title = 'Sifarişin geri göndərilməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş geri göndərildi!', 'id' => $id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
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

    //show order for users
    private function show_orders_for_users(Request $request) {
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Category not found!']);
        }

        //search start
        $where_product = '';
        $where_vehicle_id = 0;
        $where_status_id = 0;
        $where_start_date = '1900-01-01 00:00:00';
        $where_end_date = Carbon::now();

        $where_arr = array();

        if (!empty($request->product) && $request->product != ''  && $request->product != null) {
            $where_product = $request->product;
        }

        if (!empty($request->vehicle) && $request->vehicle != ''  && $request->vehicle != null) {
            $where_vehicle_id = $request->vehicle;
            $where_arr['Orders.vehicle_id'] = $where_vehicle_id;
        }

        if (!empty($request->status) && $request->status != ''  && $request->status != null) {
            $where_status_id = $request->status;
            $where_arr['Orders.last_status_id'] = $where_status_id;
        }

        if (!empty($request->start_date) && $request->start_date != ''  && $request->start_date != null) {
            $where_start_date = $request->start_date;
        }

        if (!empty($request->end_date) && $request->end_date != ''  && $request->end_date != null) {
            $where_end_date = $request->end_date;
        }
        //search end

        $orders = Orders::leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'Orders.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'Orders.position_id', '=', 'p.id')->leftJoin('lb_status as status', 'Orders.last_status_id', '=', 'status.id')->leftJoin('users', 'Orders.MainPerson', '=', 'users.id')->where(['Orders.deleted' => 0, 'Orders.category_id' => $request->cat_id, 'Orders.DepartmentID' => Auth::user()->DepartmentID()])->whereNull('Orders.delivered_person')->where('Orders.Product', 'like', '%'.$where_product.'%')->where($where_arr)->where('Orders.created_at', '>=', $where_start_date)->where('Orders.created_at', '<=', $where_end_date)->select('Orders.id', 'Orders.position_id', 'Orders.vehicle_id', 'Orders.Product', 'Orders.Translation_Brand', 'Orders.Part', 'Orders.WEB_link', 'image', 'u.Unit', 'Orders.unit_id', 'Orders.Pcs', 'Orders.Remark', 'c.process', 'v.Marka', 'p.position', 'Orders.category_id', 'Orders.deffect_doc', 'Orders.created_at', 'Orders.ReportDocument', 'Orders.confirmed', 'Orders.confirmed_at', 'Orders.ReportNo', 'Orders.last_status_id as status_id', 'status.status', 'status.color as status_color', 'users.name as user_name', 'users.surname as user_surname')->orderBy('Orders.id', 'DESC')->get();

        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

        return response(['case' => 'success', 'orders' => $orders, 'category_id' => $request->cat_id, 'units'=>$units, 'positions'=>$positions, 'vehicles'=>$vehicles]);
    }

    //delete order
    private function delete_order(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id not found!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();
            $delete_order = Orders::where(['id' => $id])->update(['deleted' => 1, 'deleted_at' => $date]);

            if ($delete_order) {
                if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                            sizin '" . $user['Product'] . "' adlı sifarişiniz silinmişdir.";
                    $title = 'Sifarişin silinməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş silindi!', 'id' => $id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //show order for chief
    private function show_orders_for_chief(Request $request) {
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Kateqoriya tapılmadı!']);
        }

        //search start
        $where_product = '';
        $where_vehicle_id = 0;
        $where_status_id = 0;
        $where_start_date = '1900-01-01 00:00:00';
        $where_end_date = Carbon::now();

        $where_arr = array();

        if (!empty($request->product) && $request->product != ''  && $request->product != null) {
            $where_product = $request->product;
        }

        if (!empty($request->vehicle) && $request->vehicle != ''  && $request->vehicle != null) {
            $where_vehicle_id = $request->vehicle;
            $where_arr['Orders.vehicle_id'] = $where_vehicle_id;
        }

        if (!empty($request->status) && $request->status != ''  && $request->status != null) {
            $where_status_id = $request->status;
            $where_arr['Orders.last_status_id'] = $where_status_id;
        }

        if (!empty($request->start_date) && $request->start_date != ''  && $request->start_date != null) {
            $where_start_date = $request->start_date;
        }

        if (!empty($request->end_date) && $request->end_date != ''  && $request->end_date != null) {
            $where_end_date = $request->end_date;
        }
        //search end

        $orders = Orders::leftJoin('users', 'Orders.MainPerson', '=', 'users.id')->leftJoin('users as chief', 'Orders.ChiefID', '=', 'chief.id')->leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'Orders.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'Orders.position_id', '=', 'p.id')->leftJoin('lb_status as status', 'Orders.last_status_id', '=', 'status.id')->where(['Orders.deleted' => 0, 'Orders.category_id' => $request->cat_id, 'Orders.DepartmentID' => Auth::user()->DepartmentID()])->whereNull('Orders.delivered_person')->where('Orders.Product', 'like', '%'.$where_product.'%')->where($where_arr)->where('Orders.created_at', '>=', $where_start_date)->where('Orders.created_at', '<=', $where_end_date)->select('Orders.id', 'Orders.Product', 'Orders.Translation_Brand', 'Orders.Part', 'Orders.WEB_link', 'image', 'u.Unit', 'Orders.unit_id', 'Orders.Pcs', 'Orders.Remark', 'c.process', 'v.Marka', 'v.QN', 'v.Tipi',  'p.position', 'Orders.category_id', 'Orders.deffect_doc', 'Orders.created_at', 'Orders.confirmed', 'Orders.confirmed_at' , 'Orders.ReportDocument', 'Orders.ReportNo', 'Orders.confirmed_at', 'users.name as user_name', 'users.surname as user_surname', 'chief.name as chief_name', 'chief.surname as chief_surname', 'Orders.last_status_id as status_id', 'status.status', 'status.color as status_color')->orderBy('Orders.id', 'DESC')->get();
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();

        return response(['case' => 'success', 'orders' => $orders, 'category_id' => $request->cat_id, 'units'=>$units]);
    }

    //cancel order for chief
    private function cancel_order_for_chief(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadl!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();
//            $cancel_order = Orders::where(['id' => $id])->update(['situation_id'=>9, 'confirmed_at'=>$date]); //istifadeciye geri gonderildi
            $status_arr['order_id'] = $id; //istifadeciye geri gonderildi
            $status_arr['status_id'] = 9;
            $cancel_order = OrderStatus::create($status_arr);
            Orders::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            if ($cancel_order) {
                if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                    sizin <b>" . $user['Product'] . "</b> adlı sifarişiniz department rəhbəriniz tərəfindən qəbul edilmədi.";
                    $title = 'Sifarişin geri çevrilməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş geri çevrildi!', 'id' => $id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //confirm alternative for supply chief
    private function confirm_alternative_for_supply_chief(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'İd tapılmadı!']);
        }
        try {
            $id = $request->id;
            Alternatives::where(['id' => $id])->update(['confirm_chief' => 1]);
            $order = Alternatives::where(['id'=>$id])->select('OrderID')->first();
            $order_id = $order['OrderID'];

//            if (Orders::where(['id'=>$order_id, 'situation_id'=>10, 'deleted'=>0])->count() == 0) {
            if (OrderStatus::where(['order_id'=>$order_id, 'status_id'=>10, 'deleted'=>0])->count() == 0) {
//                Orders::where(['id'=>$order_id])->update(['situation_id'=>10]); //direktora gonderilib
                $status_arr['order_id'] = $order_id;
                $status_arr['status_id'] = 10; //direktora gonderilib
                OrderStatus::create($status_arr);

                if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                    //send mail to user
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                        sizin <b>" . $user['Product'] . "</b> adlı sifarişiniz direktora göndərilib.";
                    $title = 'Sifarişin direktora göndərilməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);

                    //send mail to supply
                    $supply = Orders::leftJoin('users as u', 'Orders.SupplyID', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $supply['email'];
                    $to = $supply['name'] . ' ' . $supply['surname'];
                    $message = $supply['name'] . " " . $supply['surname'] . ",
                        </br><b>" . $user['Product'] . "</b> adlı sifarişi üçün alternativ təsdiqləndi və direktora göndərildi.";
                    $title = 'Alternativin təsdiqlənməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Təsdiq edildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //select supply for order
    private function select_supply_for_order(Request $request) {
        $validator = Validator::make($request->all(), [
            'supply_id' => 'required|integer',
            'order_id' => 'required|integer',
            'cat_id' => 'integer'
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadı!']);
        }

        $cat_id = $request->cat_id;

        $select_supply = Orders::where(['id'=>$request->order_id, 'deleted'=>0])->update(['SupplyID'=>$request->supply_id]);

        if ($select_supply) {
            if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                $supply = User::where(['id'=>$request->supply_id])->select('name', 'surname', 'email')->first();

                $order = Orders::leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->leftJoin('Departments as d', 'u.DepartmentID', '=', 'd.id')->where(['Orders.id'=>$request->order_id])->select('Orders.Product', 'c.process', 'u.name', 'u.surname', 'd.Department')->first();

                $email = $supply['email'];
                $to = $supply['name'] . ' ' . $supply['surname'];
                $message = $supply['name'] . " " . $supply['surname'] . ",
                    yeni sifariş var. </br>
                    Sifarişi verən şəxs: ".$order->name." ".$order->surname .".</br>
                    Sifarişi verən department: ".$order->Department.".</br>
                    Sifarişin adı: ". $order->Product .".</br>
                    Sifarişin kateqoriyası: ". $order->process .".
                ";
                $title = 'Yeni sifariş';

                app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
            }
        }

        return response(['case'=>'success', 'title'=>'Uğurlu!', 'content'=>'Təchizatçı uğurla seçildi.', 'type'=>'select_supply', 'category_id'=>$cat_id]);
    }

    //show alternative
    private function show_alternative(Request $request) {
        $alternatives = Alternatives::leftJoin('lb_countries as c', 'lb_Alternatives.country_id', '=', 'c.id')->leftJoin('lb_sellers', 'lb_Alternatives.company_id', '=', 'lb_sellers.id')->leftJoin('lb_currencies_list as cur', 'lb_Alternatives.currency_id', '=', 'cur.id')->leftJoin('lb_units_list as u', 'lb_Alternatives.unit_id', '=', 'u.id')->where(['lb_Alternatives.OrderID'=>$request->order_id, 'lb_Alternatives.deleted'=>0])->select('lb_Alternatives.*', 'u.Unit', 'c.country_name as country', 'cur.cur_name as currency', 'lb_sellers.seller_name as company', 'suggestion')->get();
        $order = Orders::where(['id'=>$request->order_id])->select('Product', 'Translation_Brand', 'Part')->first();

        return response(['case'=>'success', 'alternatives'=>$alternatives, 'order'=>$order]);
    }

    //show orders for supply
    private function show_orders_for_supply(Request $request) {
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Kateqoriya tapılmadl!']);
        }

        //search start
        $where_product = '';
        $where_supply_id = 0;
        $where_department_id = 0;
        $where_vehicle_id = 0;
        $where_status_id = 0;
        $where_start_date = '1900-01-01 00:00:00';
        $where_end_date = Carbon::now();

        $where_arr = array();

        if (!empty($request->product) && $request->product != ''  && $request->product != null) {
            $where_product = $request->product;
        }

        if (!empty($request->supply) && $request->supply != ''  && $request->supply != null) {
            $where_supply_id = $request->supply;
            if ($where_supply_id == 'null') {
                $where_arr['Orders.SupplyID'] = null;
            } else {
                $where_arr['Orders.SupplyID'] = $where_supply_id;
            }
        }

        if (!empty($request->department) && $request->department != ''  && $request->department != null) {
            $where_department_id = $request->department;
            $where_arr['Orders.DepartmentID'] = $where_department_id;
        }

        if (!empty($request->vehicle) && $request->vehicle != ''  && $request->vehicle != null) {
            $where_vehicle_id = $request->vehicle;
            $where_arr['Orders.vehicle_id'] = $where_vehicle_id;
        }

        if (!empty($request->status) && $request->status != ''  && $request->status != null) {
            $where_status_id = $request->status;
            $where_arr['Orders.last_status_id'] = $where_status_id;
        }

        if (!empty($request->start_date) && $request->start_date != ''  && $request->start_date != null) {
            $where_start_date = $request->start_date;
        }

        if (!empty($request->end_date) && $request->end_date != ''  && $request->end_date != null) {
            $where_end_date = $request->end_date;
        }
        //search end

        if (Auth::user()->chief() == 1) {
            $orders = Orders::leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'Orders.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'Orders.position_id', '=', 'p.id')->leftJoin('users', 'Orders.MainPerson', '=', 'users.id')->leftJoin('users as chief', 'Orders.ChiefID', '=', 'chief.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'Orders.SupplyID', '=', 'supply.id')->leftJoin('lb_status as status', 'Orders.last_status_id', '=', 'status.id')->whereNull('Orders.delivered_person')->where('Orders.Product', 'like', '%'.$where_product.'%')->where($where_arr)->where('Orders.created_at', '>=', $where_start_date)->where('Orders.created_at', '<=', $where_end_date)->where(['Orders.deleted' => 0, 'Orders.category_id' => $request->cat_id, 'Orders.confirmed'=>1])->select('Orders.id', 'Orders.Product', 'Orders.Translation_Brand', 'Orders.Part', 'Orders.WEB_link', 'image', 'u.Unit', 'Orders.Pcs', 'Orders.Remark', 'c.process', 'v.Marka as vehicle', 'v.QN', 'v.Tipi', 'p.position', 'Orders.category_id', 'Orders.deffect_doc', 'Orders.created_at', 'Orders.SupplyID', 'supply.name as supply_name', 'supply.surname as supply_surname', 'Orders.vehicle_id', 'Orders.unit_id', 'Orders.position_id', 'Orders.ReportDocument', 'Orders.confirmed', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as user_department', 'chief.name as chief_name', 'chief.surname as chief_surname', 'Orders.confirmed_at', 'Orders.last_status_id as status_id', 'status.status', 'status.color as status_color')->get();
        }
        else {
            $orders = Orders::leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'Orders.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'Orders.position_id', '=', 'p.id')->leftJoin('users', 'Orders.MainPerson', '=', 'users.id')->leftJoin('users as chief', 'Orders.ChiefID', '=', 'chief.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('lb_status as status', 'Orders.last_status_id', '=', 'status.id')->whereNull('Orders.delivered_person')->where('Orders.Product', 'like', '%'.$where_product.'%')->where(['Orders.SupplyID'=>Auth::id()])->where($where_arr)->where('Orders.created_at', '>=', $where_start_date)->where('Orders.created_at', '<=', $where_end_date)->where(['Orders.deleted' => 0, 'Orders.category_id' => $request->cat_id, 'Orders.confirmed'=>1])->select('Orders.id', 'Orders.Product', 'Orders.Translation_Brand', 'Orders.Part', 'Orders.WEB_link', 'image', 'u.Unit', 'Orders.Pcs', 'Orders.Remark', 'c.process', 'v.Marka as vehicle', 'v.QN', 'v.Tipi', 'p.position', 'Orders.category_id', 'Orders.deffect_doc', 'Orders.created_at', 'Orders.SupplyID', 'Orders.vehicle_id', 'Orders.unit_id', 'Orders.position_id', 'Orders.ReportDocument', 'Orders.confirmed', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as user_department', 'chief.name as chief_name', 'chief.surname as chief_surname', 'Orders.confirmed_at', 'Orders.last_status_id as status_id', 'status.status', 'status.color as status_color')->get();
        }

        $purchases = Purchase::leftjoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->where(['Purchases.deleted'=>0])->select('a.OrderID')->get();

        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

        return response(['case' => 'success', 'orders' => $orders, 'category_id' => $request->cat_id, 'purchases'=>$purchases, 'units'=>$units, 'vehicles'=>$vehicles, 'positions'=>$positions]);
    }

    //create alternative
    private function create_alternative(Request $request) {
        $validator = Validator::make($request->all(), [
            'OrderID' => 'required|integer',
            'unit_id' => 'required|integer',
            'Product' => 'required|string|max:300',
            'Brend' => 'required|string|max:255',
            'Model' => 'required|string|max:255',
            'PartSerialNo' => 'required|string|max:255',
            'date' => 'required|date',
            'cost' => 'required',
            'country_id' => 'required|integer',
            'currency_id' => 'required|integer',
            'company_id' => 'required|integer',
            'pcs' => 'required',
            'store_type' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Lazımlı xanaları doldurun!']);
        }

        $order_id = $request->OrderID;

        $order = Orders::where(['id'=>$order_id, 'deleted'=>0, 'confirmed'=>1])->count();
        if ($order == 0) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş tapılmadı!']);
        }

        $request->merge(['deleted' => 0, 'confirm_chief'=>0]);

        if (isset($request->picture)) {
            $validator_file = Validator::make($request->all(), [
                'picture' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
            if ($validator_file->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta! (Şəkil)', 'content' => 'Fayl tipləri: jpeg,png,jpg,gif,svg!']);
            }

            $image = Input::file('picture');
            $image_ext = $image->getClientOriginalExtension();
            $image_name = 'order_' . str_random(4) . '_' . microtime() . '.' . $image_ext;
            Storage::disk('uploads')->makeDirectory('files/alternatives/images');
            Image::make($image->getRealPath())->save('uploads/files/alternatives/images/' . $image_name);
            Image::make($image->getRealPath())->resize(480, 480)->save('uploads/images/' . $image_name);
            $image_address = '/uploads/files/alternatives/images/' . $image_name;

            $request['image'] = $image_address;
        }

        try {
            unset($request['picture']);
//                $request = Input::except('picture');

            if (Auth::user()->chief() == 1) {
                $request->merge(['confirm_chief'=>1]);
            }

            $create_alternative = Alternatives::create($request->all());
            Alternatives::where(['OrderID'=>$order_id, 'deleted'=>0])->update(['DirectorRemark'=>null]);
            $alts = Alternatives::leftJoin('lb_countries as c', 'lb_Alternatives.country_id', '=', 'c.id')->leftJoin('lb_sellers', 'lb_Alternatives.company_id', '=', 'lb_sellers.id')->leftJoin('lb_currencies_list as cur', 'lb_Alternatives.currency_id', '=', 'cur.id')->leftJoin('lb_units_list as u', 'lb_Alternatives.unit_id', '=', 'u.id')->where(['lb_Alternatives.OrderID'=>$request->OrderID, 'lb_Alternatives.deleted'=>0])->orderBy('lb_Alternatives.id', 'DESC')->select('lb_Alternatives.*', 'u.Unit', 'c.country_name as country', 'cur.cur_name as currency', 'lb_sellers.seller_name as company')->first();

//            Orders::where(['id'=>$order_id])->update(['situation_id'=>8]); //Alternativ yaradilib

            $status_arr['order_id'] = $order_id;
            $status_arr['status_id'] = 8; //Alternativ yaradilib
            OrderStatus::create($status_arr);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Alternativ əlavə edildi!', 'order_id' => $order_id, 'type' => 'add_alternative', 'alts'=>$alts]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Alternativ əlavə edilərkən səhv baş verdi!']);
        }
    }

    //get image
    private function get_image(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadı!']);
        }

        $order = Orders::where(['id' => $request->id])->select('image')->first();
        $image = '<img src="' . $order->image . '"  width="400" height="200">';
        $image .= '<br><br><a class="btn btn-primary" href="' . $order->image . '" target="_blank">Şəkilə tam ölçüdə baxmaq</a>';

        return response(['case' => 'success', 'data' => $image]);
    }

    //get remark
    private function get_remark(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'İd tapılmadı!']);
        }

        $id = $request->id;
        $data = '';

        $order = Orders::where(['id' => $id])->select('Remark', 'confirmed')->first();
        $status = OrderStatus::where(['order_id'=>$id, 'deleted'=>0])->orderBy('id', 'DESC')->select('status_id')->first();

        $remark = '<span id="remark-span">' . $order['Remark'] . '</span>';

        if ($status['status_id'] == 9 || $order['confirmed'] == 1) {
            $btn = '<span id="remark-btn"><button title="Düymə deaktivdir" class="btn btn-warning">Dəyişdirmək</button></span>';
        }
        else {
            $btn = '<span id="remark-btn"><button class="btn btn-primary" onclick="edit_remark(' . $id . ');">Dəyişdirmək</button></span>';
        }

        $data = $remark . '<br><br>' . $btn;

        return response(['case' => 'success', 'data' => $data, 'remark'=>$order['Remark']]);
    }

    //update remark
    private function update_remark(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'remark' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'İd tapılmadı!']);
        }

        try {
            $id = $request->id;
            $remark = $request->remark;

            $order = Orders::where(['id' => $id])->select('confirmed')->first();
            $status = OrderStatus::where(['order_id'=>$id, 'deleted'=>0])->orderBy('id', 'DESC')->select('status_id')->first();

            if ($status['status_id'] == 9 || $order['confirmed'] == 1) {
                return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Bunun üçün icazəniz yoxdur!']);
            }

            Orders::where(['id'=>$id])->update(['remark'=>$remark]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Uğurlu!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //cancel order for supply
    private function cancel_order_for_supply(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadl!']);
        }
        try {
            $id = $request->id;
//            $cancel_order = Orders::where(['id' => $id])->update(['situation_id'=>9]); //istifadeciye geri gonderildi
            $status_arr['order_id'] = $id;
            $status_arr['status_id'] = 9; //istifadeciye geri gonderildi
            $cancel_order = OrderStatus::create($status_arr);

            if ($cancel_order) {
                if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                            sizin <b>" . $user['Product'] . "</b> adlı sifarişiniz department rəhbəriniz tərəfindən qəbul edilmədi.";
                    $title = 'Sifarişin geri çevrilməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş geri çevrildi!', 'id' => $id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //get alternative image
    private function get_alt_image(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }

        $alt = Alternatives::where(['id' => $request->id])->select('image')->first();
        $image = '<img src="' . $alt->image . '"  width="200" height="200">';
        $image .= '<br><br><a class="btn btn-primary" href="' . $alt->image . '" target="_blank">Şəkilə tam ölçüdə baxmaq</a>';

        return response(['case' => 'success', 'data' => $image]);
    }

    //delete alternative
    private function delete_alternative(Request $request) {
        //delete
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Alternativ tapılmadı!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();

            $purchases = Purchase::where(['deleted'=>0])->select('AlternativeID')->distinct()->get();
//            $alternatives = Alternatives::whereIn('id', $purchases)->where(['deleted'=>0])->select('OrderID')->get();

//            if ($orders = Alternatives::whereIn('id', $purchases)->whereNotNull('DirectorRemark')->count() > 0)

            if (Alternatives::where(['id'=>$id, 'confirm_chief'=>0])->count() == 0) {
                return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Bu alternativi silmək üçün icazəniz yoxdur!']);
            }

            Alternatives::where(['id' => $id])->update(['deleted' => 1, 'deleted_at' => $date]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Alternativ silindi!', 'id' => $id, 'type' => 'alt_del']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //suggestion alternative
    private function suggestion_alternative(Request $request) {
        if (Auth::user()->chief() == 0) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sizin bu əməliyyat üçün hüququnuz yoxdur!']);
        }
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Alternativ tapılmadı!']);
        }
        try {
            $id = $request->id;

            $alts = Alternatives::where(['id'=>$id])->select('OrderID')->first();

            Alternatives::where(['OrderID'=>$alts['OrderID']])->update(['suggestion'=>0]);

            Alternatives::where(['id' => $id])->update(['suggestion' => 1]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Alternativ tövsiyyə edildi!', 'id' => $id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //confirm order
    private function confirm_order(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş tapılmadı!']);
        }

        try {
            $order_id = $request->order_id;
            if (Orders::where(['id'=>$order_id, 'deleted'=>0, 'confirmed'=>1])->count() > 0) {
                return response(['case' => 'warning', 'title' => 'Xəta!', 'content' => 'Sifariş daha əvvəl təsdiq edilib!']);
            }

            $arr = array();
            $arr['ChiefID'] = Auth::id();
            $arr['confirmed_at'] = Carbon::now();
            $arr['confirmed'] = 1;
            $status_arr['status_id'] = 2; //tesdiqlendi
            $status_arr['order_id'] = $order_id;

            $confirm_order = Orders::where(['id'=>$order_id, 'deleted'=>0])->update($arr);
            OrderStatus::create($status_arr);

            if ($confirm_order) {
                if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                    //send mail to user
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                    sizin <b>" . $user['Product'] . "</b> adlı sifarişiniz department rəhbəriniz tərəfindən təsdiq edildi.</br>
                    Sifarişiniz təchizat şöbəsinə göndərilib.";
                    $title = 'Sifarişin təsdiqlənməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);

                    //send mail to supply chief
                    $supply = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['d.authority_id'=>4, 'users.chief'=>1, 'users.deleted'=>0])->select('users.name', 'users.surname', 'users.email')->first();

                    $order = Orders::leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->leftJoin('Departments as d', 'u.DepartmentID', '=', 'd.id')->where(['Orders.id'=>$order_id])->select('Orders.Product', 'c.process', 'u.name', 'u.surname', 'd.Department')->first();

                    $email = $supply['email'];
                    $to = $supply['name'] . ' ' . $supply['surname'];
                    $message = $supply['name'] . " " . $supply['surname'] . ",
                    yeni sifariş var. </br>
                    Sifarişi verən şəxs: ".$order->name." ".$order->surname .".</br>
                    Sifarişi verən department: ".$order->Department.".</br>
                    Sifarişin adı: ". $order->Product .".</br>
                    Sifarişin kateqoriyası: ". $order->process .".
                ";
                    $title = 'Yeni sifariş';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }
            }

            return response(['case' => 'success', 'order_id'=>$order_id, 'cat_id'=>$request->cat_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş təsdiq edilərkən səhv baş verdi!']);
        }
    }

    //add order
    private function add_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Product' => 'required|string|max:300',
            'Pcs' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'Remark' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Lazımlı xanaları doldurun (ad, miqdar, səbəb)!']);
        }

        $product = $request->Product;

        if (isset($request->picture)) {
            $validator_file = Validator::make($request->all(), [
                'picture' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
            if ($validator_file->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta! (Şəkil)', 'content' => 'Fayl tipləri: jpeg,png,jpg,gif,svg!']);
            }

            $image = Input::file('picture');
            $image_ext = $image->getClientOriginalExtension();
            $image_name = 'order_' . str_random(4) . '_' . microtime() . '.' . $image_ext;
            Storage::disk('uploads')->makeDirectory('files/orders/images');
            Image::make($image->getRealPath())->save('uploads/files/orders/images/' . $image_name);
            Image::make($image->getRealPath())->resize(480, 480)->save('uploads/images/' . $image_name);
            $image_address = '/uploads/files/orders/images/' . $image_name;

            $request['image'] = $image_address;
        }

        if (isset($request->defect)) {

            $file = Input::file('defect');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = 'defect_' . str_random(4) . '.' . $file_ext;
            Storage::disk('uploads')->makeDirectory('files/orders/defects');
            $file->move('uploads/files/orders/defects/', $file_name);
            $file_address = '/uploads/files/orders/defects/' . $file_name;

            $reportDocument = $file_address;
            $request->merge(['deffect_doc' => $reportDocument]);
        }

        if (isset($request->report)) {

            $file2 = Input::file('report');
            $file_ext2 = $file2->getClientOriginalExtension();
            $file_name2 = 'report_' . str_random(4) . '.' . $file_ext2;
            Storage::disk('uploads')->makeDirectory('files/reports');
            $file2->move('uploads/files/reports/', $file_name2);
            $file_address2 = '/uploads/files/reports/' . $file_name2;

            $reportDoc = $file_address2;
            $request->merge(['ReportDocument' => $reportDoc]);
        }

        try {
            $cat_id = $request->category_id;

            $unit_id = $request['unit_id'];

            $request->merge(['deleted' => 0, 'MainPerson' => Auth::id(), 'DepartmentID' => Auth::user()->DepartmentID()]);

            unset($request['picture']);
            $request = Input::except('picture');

            unset($request['defect']);
            $request = Input::except('defect');

            unset($request['report']);
            $request = Input::except('report');

            unset($request['type']);

            $add_order = Orders::create($request);

            if ($add_order) {
                $status_arr['order_id'] = $add_order->id;
                $status_arr['status_id'] = 1; //gozlemede
                OrderStatus::create($status_arr);

                Units::where('id', $unit_id)->increment('use_count');

                if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                    $chiefs = User::where(['DepartmentID'=>Auth::user()->DepartmentID(), 'chief'=>1, 'deleted'=>0])->select('name', 'surname', 'email')->get();
                    $category = Categories::where(['id'=>$cat_id])->select('process')->first();

                    $email = array();
                    $to = array();
                    foreach ($chiefs as $chief) {
                        array_push($email, $chief->email);
                        array_push($to, $chief->name . ' ' . $chief->surname);
                    }

                    $message = "Yeni sifariş var. </br>
                                Sifarişi verən: ". Auth::user()->name." ".Auth::user()->surname .".</br>
                                Sifariş: ". $product .".</br>
                                Sifarşin kateqoriyası: ". $category->process .".
                    ";
                    $title = 'Yeni sifariş';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş yaradıldı!', 'type'=>'add_order', 'category_id'=>$cat_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş yaradılarkən səhv baş verdi!']);
        }
    }

    //update order
    private function update_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'Product' => 'required|string|max:300',
            'Pcs' => 'required',
            'unit_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Lazımlı xanaları boş buraxmayın!']);
        }

        try {
            $id = $request->id;
            unset($request['id']);
            unset($request['_token']);
            unset($request['type']);

            unset($request['picture']);
            $request = Input::except('picture');

            Orders::where(['id' => $id])->update($request);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Məlumatlar dəyişdirildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Məlumatlar dəyişdirilərkən səhv baş verdi!']);
        }
    }

    //update order image function
    private function update_order_image(Request $request) {
        if (isset($request->picture)) {
            $validator_file = Validator::make($request->all(), [
                'id' => 'required|integer',
                'picture' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
            if ($validator_file->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta! (Şəkil)', 'content' => 'Fayl tipləri: jpeg,png,jpg,gif,svg!']);
            }

            $image = Input::file('picture');
            $image_ext = $image->getClientOriginalExtension();
            $image_name = 'order_' . str_random(4) . '_' . microtime() . '.' . $image_ext;
            Storage::disk('uploads')->makeDirectory('files/orders/images');
            Image::make($image->getRealPath())->save('uploads/files/orders/images/' . $image_name);
            Image::make($image->getRealPath())->resize(480, 480)->save('uploads/images/' . $image_name);
            $image_address = '/uploads/files/orders/images/' . $image_name;

            $id = $request->id;

            try {
                Orders::where(['id'=>$id])->update(['image'=>$image_address]);

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Şəkil dəyişdirildi!', 'type' => 'update_order_image']);
            } catch (\Exception $e) {
                    return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Şəkil dəyişdirilərkən səhv baş verdi!']);
                }
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Şəkil seçilməyib!']);
        }
    }
}
