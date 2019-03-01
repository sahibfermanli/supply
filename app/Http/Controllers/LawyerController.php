<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Alternatives;
use App\Orders;
use App\OrderStatus;
use App\Positions;
use App\Purchase;
use App\Settings;
use App\Units;
use App\User;
use App\Vehicles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LawyerController extends HomeController
{
    //get pending orders
    public function get_pending_orders() {
        if (Accounts::where(['deleted'=>0])->count() == 0) {
            Session::flash('message', 'Hesab tapılmadı!');
            Session::flash('class', 'warning');
            Session::flash('display', 'block');
            return redirect('/');
        }

        if (empty(Input::get('account_id'))) {
            $account_id = 0;
            $table_display = 'none';
            $message_display = 'block';

            $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftjoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('companies as c', 'accounts.company_id', '=', 'c.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['accounts.deleted'=>0, 'Purchases.deleted'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'c.name as company', 'c.phone', 'c.address', 'u.Unit', 'accounts.account_no', 'accounts.send_at as account_date', 'users.name', 'users.surname', 'd.Department', 'o.image', 'o.deffect_doc', 'o.id as order_id', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date')->get();
        }
        else {
            $account_id = Input::get('account_id');

            $account_id = trim($account_id);

            if (Auth::user()->chief() == 1) {
                //lawyer chief
                if (Accounts::where(['id'=>$account_id, 'send'=>1, 'lawyer_confirm'=>1, 'deleted'=>0])->count() == 0) {
                    return redirect('/law/chief/pending/orders');
                }
            }
            else {
                //lawyer user
                if (Accounts::where(['id'=>$account_id, 'send'=>1, 'deleted'=>0])->count() == 0) {
                    return redirect('/law/pending/orders');
                }
            }

            $table_display = 'block';
            $message_display = 'none';

            $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftjoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('lb_sellers as c', 'accounts.company_id', '=', 'c.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['Purchases.account_id'=>$account_id, 'accounts.deleted'=>0, 'Purchases.deleted'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'Purchases.account_id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'c.seller_name as company', 'u.Unit', 'accounts.account_no', 'accounts.send_at as account_date', 'users.name', 'users.surname', 'd.Department', 'o.image', 'o.deffect_doc', 'o.id as order_id', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date')->get();
        }

        return view('backend.orders_for_lawyers')->with(['orders'=>$orders, 'table_display'=>$table_display, 'message_display'=>$message_display]);
    }

    //post pending orders
    public function post_pending_orders(Request $request) {
        if ($request->type == 'show_image') {
            //show order image
            return $this->show_order_image($request);
        }
        else if ($request->type == 'cancel_order') {
            //cancel order
            return $this->cancel_order($request);
        }
        else if ($request->type == 'confirm_account') {
            //confirm account
            return $this->confirm_account();
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //show order image
    private function show_order_image(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }

        $order = Orders::where(['id' => $request->id])->select('image')->first();
        $image = '<img src="' . $order->image . '"  width="200" height="200">';
        $image .= '<br><br><a class="btn btn-primary" href="' . $order->image . '" target="_blank">Şəkilə tam ölçüdə baxmaq</a>';

        return response(['case' => 'success', 'data' => $image]);
    }

    //cancel order
    private function cancel_order(Request $request) {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|integer',
            'order_id' => 'required|integer',
            'remark' => 'required|string|max:1000',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $account_id = Input::get('account_id');
            $account_id = trim($account_id);

            $message_body_for_user = '';

            if (Purchase::where(['account_id'=>$account_id, 'deleted'=>0, 'completed'=>0])->count() == 1) {
                $curent_date = Carbon::now();

                if (Auth::user()->authority() == 6) {
                    //lawyer
                    $status_id = 12;
                    $message_body_for_user = 'hüquq şöbəsi tərəfindən qəbul edilmədi.';
                    if (Auth::user()->chief == 1) {
                        //lawyer chief
                        Accounts::where(['id'=>$account_id])->update(['send'=>0, 'send_at'=>null, 'lawyer_chief_confirm'=>0, 'lawyer_chief_confirm_at'=>$curent_date, 'lawyer_remark'=>$request->remark]);
                    }
                    else {
                        //lawyer user
                        Accounts::where(['id'=>$account_id])->update(['send'=>0, 'send_at'=>null, 'lawyer_confirm'=>0, 'lawyer_confirm_at'=>$curent_date, 'lawyer_remark'=>$request->remark]);
                    }
                }
                else if (Auth::user()->authority() == 7) {
                    //finance
                    $status_id = 19;
                    $message_body_for_user = 'maaliyə şöbəsi tərəfindən qəbul edilmədi.';
                    if (Auth::user()->chief() == 1) {
                        //chief
                        Accounts::where(['id'=>$account_id])->update(['send'=>0, 'send_at'=>null, 'finance_chief_confirm'=>0, 'finance_chief_confirm_at'=>$curent_date, 'lawyer_remark'=>$request->remark]);
                    }
                    else {
                        //user
                        Accounts::where(['id'=>$account_id])->update(['send'=>0, 'send_at'=>null, 'finance_confirm'=>0, 'finance_confirm_at'=>$curent_date, 'lawyer_remark'=>$request->remark]);
                    }
                }
                else if (Auth::user()->authority() == 5 && Auth::user()->auditor() == 8) {
                    //Vuqar Zeynalov
                    $message_body_for_user = 'direktorun hüquqi işlər üzrə müavini tərəfindən qəbul edilmədi.';
                    Accounts::where(['id'=>$account_id])->update(['send'=>0, 'send_at'=>null, 'director_lawyer_confirm'=>0, 'director_lawyer_confirm_at'=>$curent_date, 'lawyer_remark'=>$request->remark]);
                    $status_id = 18;
                }
                else {
                    return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
                }
            }

            Purchase::where(['id'=>$request->purchase_id])->update(['account_id'=>null]);

//            Orders::where(['id'=>$request->order_id])->update(['situation_id'=>$status_id]);
            $status_arr['order_id'] = $request->order_id;
            $status_arr['status_id'] = $status_id;
            OrderStatus::create($status_arr);

            if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                //send email to user
                $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$request->order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email = $user['email'];
                $to = $user['name'] . ' ' . $user['surname'];
                $message = $user['name'] . " " . $user['surname'] . ",
                    sizin '" . $user['Product'] . "' adlı sifarişiniz " . $message_body_for_user;
                $title = 'Sifarişin geri çevrilməsi';

                app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş geri çevrildi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //confirm account
    private function confirm_account() {
        if (empty(Input::get('account_id'))) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
        }

        try {
            $account_id = Input::get('account_id');
            $account_id = trim($account_id);

            if (Purchase::where(['deleted'=>0, 'completed'=>0, 'account_id'=>$account_id])->count() == 0) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Bu hesabda heç bir sifariş yoxdur!']);
            }

            $current_date = Carbon::now();

            if (Auth::user()->authority() == 6) {
                //lawyer
                if (Auth::user()->chief() == 1) {
                    //lawyer chief
                    $update = Accounts::where(['id'=>$account_id, 'deleted'=>0, 'send'=>1])->update(['lawyer_chief_confirm'=>1, 'lawyer_chief_confirm_at'=>$current_date]);
                    $status_id = 17; //Direktorun hüquqi məsələlər üzrə müavini
                }
                else {
                    //lawyer user
                    $update = Accounts::where(['id'=>$account_id, 'deleted'=>0, 'send'=>1])->update(['lawyer_confirm'=>1, 'lawyer_confirm_at'=>$current_date]);
                    $status_id = 14; //Hüquq şöbəsinin rəhbərindən təsdiq gözləyir
                }
            }
            else if (Auth::user()->authority() == 7) {
                //finance
                if (Auth::user()->chief() == 1) {
                    //chief
                    $update = Accounts::where(['id'=>$account_id, 'deleted'=>0, 'send'=>1])->update(['finance_chief_confirm'=>1, 'finance_chief_confirm_at'=>$current_date]);
                    $status_id = 15; //Sifariş tamamlandı
                    //complete order
                    Purchase::where(['account_id'=>$account_id, 'deleted'=>0, 'completed'=>0])->update(['completed'=>1, 'completed_at'=>$current_date]);
                }
                else {
                    //user
                    $update = Accounts::where(['id'=>$account_id, 'deleted'=>0, 'send'=>1])->update(['finance_confirm'=>1, 'finance_confirm_at'=>$current_date]);
                    $status_id = 16; //Mühasibat şöbəsinin rəhbərindən təsdiq gözləyir
                }
            }
            else if (Auth::user()->authority() == 5 && Auth::user()->auditor() == 8) {
                //Vuqar Zeynalov
                $update = Accounts::where(['id'=>$account_id, 'deleted'=>0, 'send'=>1])->update(['director_lawyer_confirm'=>1, 'director_lawyer_confirm_at'=>$current_date]);
                $status_id = 13; //Mühasibat şöbəsinə göndərildi
            }
            else {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
            }

            if ($update) {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->where(['Purchases.account_id'=>$account_id, 'Purchases.deleted'=>0])->select('a.OrderID')->get();

//                Orders::whereIn('id', $orders)->update(['situation_id'=>$status_id]);
                $status_arr['status_id'] = $status_id;
                foreach ($orders as $order) {
                    $status_arr['order_id'] = $order->OrderID;
                    OrderStatus::create($status_arr);
                }
            }


            return response(['case' => 'success']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }


    //alternatives
    //show orders
    public function get_orders_for_alts()
    {
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

        return view('backend.alternatives_for_supply')->with(['units' => $units, 'vehicles' => $vehicles, 'positions' => $positions]);
    }

    //post orders
    public function post_order_for_alts(Request $request)
    {
        if ($request->type == 1) {
            //delete order for alternatives
            return $this->delete_order_for_alt($request);
        } else if ($request->type == 2) {
            //get orders for alternatives
            return $this->show_orders_for_alt($request);
        } else if ($request->type == 3) {
            //get order remark
            return $this->get_remark($request);
        } else if ($request->type == 4) {
            //get order image
            return $this->get_order_image($request);
        } else if ($request->type == 5) {
            //free
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
        else if ($request->type == 6) {
            //show alternatives
            return $this->show_alternatives($request);
        }
        else if ($request->type == 7) {
            //alternative add to purchase (create purchase)
            return $this->create_purchase($request);
        }
        else if ($request->type == 8) {
            //cancel alternatives
            return $this->cancel_alternatives($request);
        }
        else if ($request->type == 9) {
            //get alternative image
            return $this->get_alternative_image($request);
        }
        else if ($request->type == 'show_status') {
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

    //delete order for alternatives
    private function delete_order_for_alt(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'row_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'İd tapılmadı!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();
            $delete_order = Orders::where(['id' => $id])->update(['deleted' => 1, 'deleted_at' => $date]);

            if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                if ($delete_order) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                    sizin '" . $user['Product'] . "' adlı sifarişiniz hüquq şöbəsi tərəfindən silinmişdir.";
                    $title = 'Sifarişin silinməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş silindi!', 'row_id' => $request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş silinərkən səhv baş verdi!']);
        }
    }

    //get orders for alternatives
    private function show_orders_for_alt(Request $request) {
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Kateqoriya tapılmadı!']);
        }

        $purchases = Purchase::where(['deleted'=>0])->select('AlternativeID')->distinct()->get();
        $alternatives = Alternatives::whereIn('id', $purchases)->where(['deleted'=>0])->select('OrderID')->get();

        $orders = Alternatives::leftJoin('Orders as o', 'lb_Alternatives.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'o.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'o.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'o.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'o.position_id', '=', 'p.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->whereNotIn('o.id', $alternatives)->whereNull('lb_Alternatives.DirectorRemark')->where(['o.deleted' => 0, 'o.category_id' => $request->cat_id, 'lb_Alternatives.deleted'=>0, 'lb_Alternatives.confirm_chief'=>1])->orderBy('o.id', 'DESC')->select('o.id', 'o.Product', 'o.Translation_Brand', 'o.Part', 'o.WEB_link', 'o.image', 'u.Unit', 'o.Pcs', 'o.Remark', 'c.process', 'v.Marka', 'p.position', 'o.category_id', 'o.deffect_doc', 'o.created_at', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as user_department')->distinct()->get();

        //get last status
        foreach ($orders as $order) {
            $order_id = $order->id;

            $statuses = OrderStatus::where(['order_status.order_id'=>$order_id, 'order_status.deleted'=>0])->leftJoin('lb_status as s', 'order_status.status_id', '=', 's.id')->select('s.id as status_id', 's.status', 's.color as status_color', 'order_status.created_at as status_date')->orderBy('order_status.id', 'Desc')->first();
            $order['last_status'] = $statuses;
        }

        return response(['case' => 'success', 'orders' => $orders, 'category_id' => $request->cat_id]);
    }

    //get order remark
    private function get_remark(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadı!']);
        }

        $order = Orders::where(['id' => $request->id])->select('Remark')->first();

        return response(['case' => 'success', 'data' => $order['Remark']]);
    }

    //get order image
    private function get_order_image(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadı!']);
        }

        $order = Orders::where(['id' => $request->id])->select('image')->first();
        $image = '<img src="' . $order->image . '"  width="200" height="200">';

        return response(['case' => 'success', 'data' => $image]);
    }

    //show alternatives
    private function show_alternatives(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş tapılmadı!']);
        }
        $order_id = $request->order_id;

        $alternatives = Alternatives::leftJoin('lb_countries as c', 'lb_Alternatives.country_id', '=', 'c.id')->leftJoin('lb_sellers', 'lb_Alternatives.company_id', '=', 'lb_sellers.id')->leftJoin('lb_currencies_list as cur', 'lb_Alternatives.currency_id', '=', 'cur.id')->leftJoin('lb_units_list as u', 'lb_Alternatives.unit_id', '=', 'u.id')->where(['lb_Alternatives.OrderID'=>$order_id, 'lb_Alternatives.deleted'=>0, 'lb_Alternatives.confirm_chief'=>1])->select('lb_Alternatives.id', 'lb_Alternatives.Brend', 'lb_Alternatives.Model', 'lb_Alternatives.PartSerialNo', 'lb_Alternatives.cost', 'lb_Alternatives.total_cost', 'lb_Alternatives.pcs', 'u.Unit', 'lb_Alternatives.date', 'c.country_name as country', 'lb_Alternatives.store_type', 'lb_Alternatives.id as alternative_id', 'cur.cur_name as currency', 'lb_sellers.seller_name as company', 'lb_Alternatives.Remark', 'lb_Alternatives.image', 'lb_Alternatives.suggestion', 'lb_Alternatives.created_at')->get();

        return response(['case' => 'success', 'alternatives'=>$alternatives, 'order_id'=>$request->order_id]);
    }

    //alternative add to purchase (create purchase)
    private function create_purchase(Request $request) {
        $validator = Validator::make($request->all(), [
            'AlternativeID' => 'required|integer',
            'OrderID' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Alternativ tapılmadı!']);
        }

        try {
            $order_id = $request->OrderID;

            unset($request['OrderID']);

            $request->merge(['deleted'=>0, 'LawyerID'=>Auth::id()]);

            Purchase::create($request->all());

            $deadline = Carbon::now();

            Orders::where(['id'=>$order_id])->update(['deadline'=>$deadline]);
            $status_arr['order_id'] = $order_id;
            $status_arr['status_id'] = 5; //Alımlara əlavə olundu
            OrderStatus::create($status_arr);

            if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                //send email to user
                $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email = $user['email'];
                $to = $user['name'] . ' ' . $user['surname'];
                $message = $user['name'] . " " . $user['surname'] . ",
                    sizin '" . $user['Product'] . "' adlı sifarişiniz alımlara əlavə edilmişdir, hesablara əlavə edilməsi üçün təchizat şöbəsində gözləyir.";
                $title = 'Sifarişin alımlara əlavə edilməsi';

                app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);

                //send email to supply chief
                $suplly_chief = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['d.authority_id'=>4, 'users.chief'=>1])->select('users.name', 'users.surname', 'users.email')->first();

                $email2 = $suplly_chief['email'];
                $to2 = $suplly_chief['name'] . ' ' . $suplly_chief['surname'];
                $message2 = $suplly_chief['name'] . " " . $suplly_chief['surname'] . ",
                    '" . $user['Product'] . "' adlı sifariş alımlara əlavə edilmişdir, hüquq şöbəsinə göndərilməsi üçün təchizat şöbəsində gözləyir.</br>
                    Sifarişi hesaba əlavə edin və hüquq şöbəsinə göndərin.";
                $title2 = 'Sifarişin alımlara əlavə edilməsi';

                app('App\Http\Controllers\MailController')->get_send($email2, $to2, $title2, $message2);

                //send email to supply
                $supply = Orders::leftJoin('users as u', 'Orders.SupplyID', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email3 = $supply['email'];
                $to3 = $supply['name'] . ' ' . $supply['surname'];
                $message3 = $supply['name'] . " " . $supply['surname'] . ",
                    '" . $supply['Product'] . "' adlı sifariş alımlara əlavə edilmişdir, hüquq şöbəsinə göndərilməsi üçün təchizat şöbəsində gözləyir.</br>
                    Sifarişi hesaba əlavə edin və hüquq şöbəsinə göndərin.";
                $title3 = 'Sifarişin alımlara əlavə edilməsi';

                app('App\Http\Controllers\MailController')->get_send($email3, $to3, $title3, $message3);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Alternativ seçildi!', 'type'=>'create_purchase']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Alternativ seçilərkən səhv baş verdi!']);
        }
    }

    //cancel alternatives
    private function cancel_alternatives(Request $request) {
        $validator = Validator::make($request->all(), [
            'OrderID' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş tapılmadı!']);
        }

        try {
            $order_id = $request->OrderID;

            unset($request['OrderID']);

            if (!isset($request->Remark)) {
                $remark = 'Qəbul edilmədi';
            }
            else {
                $remark = $request->Remark;
            }

            $status_id = 7; //techizatciya geri gonderildi

            Alternatives::where(['OrderID'=>$order_id, 'deleted'=>0])->update(['DirectorRemark'=>$remark]);
//            Orders::where(['id'=>$order_id])->update(['situation_id'=>$status_id]);
            $status_arr['order_id'] = $order_id;
            $status_arr['status_id'] = $status_id;
            OrderStatus::create($status_arr);

            if (Settings::where(['id'=>1, 'send_email'=>1])->count() > 0) {
                //send email to user
                $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email = $user['email'];
                $to = $user['name'] . ' ' . $user['surname'];
                $message = $user['name'] . " " . $user['surname'] . ",
                    sizin '" . $user['Product'] . "' adlı sifarişiniz hüquq şöbəsi tərəfindən təchizatçıya geri göndərilmişdir.</br>
                    Direktorun qeydi:</br>".$remark;
                $title = 'Sifarişin təchizatçıya geri göndərilməsi';

                app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);

                //send email to supply chief
                $suplly_chief = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['d.authority_id'=>4, 'users.chief'=>1])->select('users.name', 'users.surname', 'users.email')->first();

                $email2 = $suplly_chief['email'];
                $to2 = $suplly_chief['name'] . ' ' . $suplly_chief['surname'];
                $message2 = $suplly_chief['name'] . " " . $suplly_chief['surname'] . ",
                    '" . $user['Product'] . "' adlı sifariş hüquq şöbəsi tərəfindən təchizatçıya geri göndərilmişdir.</br>
                    Direktorun qeydi:</br>".$remark;
                $title2 = 'Sifarişin təchizatçıya geri göndərilməsi';

                app('App\Http\Controllers\MailController')->get_send($email2, $to2, $title2, $message2);

                //send email to supply
                $supply = Orders::leftJoin('users as u', 'Orders.SupplyID', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email3 = $supply['email'];
                $to3 = $supply['name'] . ' ' . $supply['surname'];
                $message3 = $supply['name'] . " " . $supply['surname'] . ",
                    '" . $supply['Product'] . "' adlı sifariş hüquq şöbəsi tərəfindən təchizatçıya geri göndərilmişdir.</br>
                    Direktorun qeydi:</br>".$remark;
                $title3 = 'Sifarişin təchizatçıya geri göndərilməsi';

                app('App\Http\Controllers\MailController')->get_send($email3, $to3, $title3, $message3);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Uğurlu!', 'type'=>'create_purchase']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //get alternative image
    private function get_alternative_image(Request $request) {
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
}
