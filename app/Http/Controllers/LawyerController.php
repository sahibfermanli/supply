<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Orders;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        }
        else {
            $account_id = Input::get('account_id');

            $account_id = trim($account_id);

            if (Accounts::where(['id'=>$account_id, 'send'=>1, 'deleted'=>0])->count() == 0) {
                return redirect('/law/pending/orders');
            }

            $table_display = 'block';
            $message_display = 'none';
        }

        $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftjoin('accounts', 'Purchases.account_id', '=', 'accounts.id')->leftJoin('companies as c', 'accounts.company_id', '=', 'c.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('users', 'o.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['Purchases.account_id'=>$account_id, 'accounts.deleted'=>0, 'Purchases.deleted'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'c.name as company', 'c.phone', 'c.address', 'u.Unit', 'accounts.account_no', 'accounts.account_doc', 'accounts.send_at as account_date', 'users.name', 'users.surname', 'd.Department', 'o.image', 'o.deffect_doc', 'o.id as order_id', 'Purchases.qaime_no', 'Purchases.qaime_doc', 'Purchases.qaime_date')->get();

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
            return $this->confirm_account($request);
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
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }
        try {
            $account_id = Input::get('account_id');
            $account_id = trim($account_id);

            if (Purchase::where(['account_id'=>$account_id, 'deleted'=>0, 'completed'=>0])->count() == 1) {
                $curent_date = Carbon::now();
                Accounts::where(['id'=>$account_id])->update(['send'=>0, 'send_at'=>null, 'lawyer_confirm'=>0, 'lawyer_confirm_at'=>$curent_date]);
            }

            Purchase::where(['id'=>$request->purchase_id])->update(['account_id'=>null]);

            Orders::where(['id'=>$request->order_id])->update(['situation_id'=>12]); //huquq terefinden qebul edilmedi

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş geri çevrildi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //confirm account
    public function confirm_account(Request $request) {
        if (empty(Input::get('account_id'))) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Hesab tapılmadı!']);
        }

        try {
            $account_id = Input::get('account_id');
            $account_id = trim($account_id);

            $current_date = Carbon::now();

//            $file = Input::file('file');
//            $file_ext = $file->getClientOriginalExtension();
//            $file_name = 'lawyer_' . str_random(4) . '_' . microtime() . '.' . $file_ext;
//            Storage::disk('uploads')->makeDirectory('files/accounts');
//            $file->move('uploads/files/accounts/', $file_name);
//            $file_address = '/uploads/files/accounts/' . $file_name;

            $update = Accounts::where(['id'=>$account_id, 'deleted'=>0, 'send'=>1])->update(['lawyer_confirm'=>1, 'lawyer_confirm_at'=>$current_date]);

            if ($update) {
                $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->where(['Purchases.account_id'=>$account_id, 'Purchases.deleted'=>0])->select('a.OrderID')->get();

                Orders::whereIn('id', $orders)->update(['situation_id'=>13]); //Mühasibat şöbəsinə göndərildi
            }


            return redirect('/law/pending/orders');
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}