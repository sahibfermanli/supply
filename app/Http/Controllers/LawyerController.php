<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Orders;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LawyerController extends HomeController
{
    public function get_pending_orders() {
        if (empty(Input::get('account_id'))) {
            $account_id = 0;
            $table_display = 'none';
            $message_display = 'block';

            $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftjoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('companies as c', 'accounts.company_id', '=', 'c.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['accounts.deleted'=>0, 'Purchases.deleted'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'c.name as company', 'c.phone', 'c.address', 'u.Unit', 'accounts.account_no', 'accounts.account_doc', 'accounts.send_at as account_date', 'users.name', 'users.surname', 'd.Department', 'o.image', 'o.deffect_doc', 'o.id as order_id', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date')->get();
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

            $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftjoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('companies as c', 'accounts.company_id', '=', 'c.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['Purchases.account_id'=>$account_id, 'accounts.deleted'=>0, 'Purchases.deleted'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'c.name as company', 'c.phone', 'c.address', 'u.Unit', 'accounts.account_no', 'accounts.account_doc', 'accounts.send_at as account_date', 'users.name', 'users.surname', 'd.Department', 'o.image', 'o.deffect_doc', 'o.id as order_id', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date')->get();
        }

        return view('backend.orders_for_lawyers')->with(['orders'=>$orders, 'table_display'=>$table_display, 'message_display'=>$message_display]);
    }

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
    public function show_order_image(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }

        $order = Orders::where(['id' => $request->id])->select('image')->first();
        $image = '<img src="' . $order->image . '"  width="200" height="200">';

        return response(['case' => 'success', 'data' => $image]);
    }

    //cancel order
    public function cancel_order(Request $request) {
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

            if (Purchase::where(['account_id'=>$account_id, 'deleted'=>0, 'completed'=>0])->count() == 1) {
                $curent_date = Carbon::now();

                if (Auth::user()->authority() == 6) {
                    //lawyer
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
                    Accounts::where(['id'=>$account_id])->update(['send'=>0, 'send_at'=>null, 'director_lawyer_confirm'=>0, 'director_lawyer_confirm_at'=>$curent_date, 'lawyer_remark'=>$request->remark]);
                }
                else {
                    return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
                }
            }

            Purchase::where(['id'=>$request->purchase_id])->update(['account_id'=>null]);

            Orders::where(['id'=>$request->order_id])->update(['situation_id'=>12]); //huquq terefinden qebul edilmedi

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş geri çevrildi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //confirm account
    public function confirm_account() {
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

                Orders::whereIn('id', $orders)->update(['situation_id'=>$status_id]);
            }


            return response(['case' => 'success']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
