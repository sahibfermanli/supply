<?php

namespace App\Http\Controllers;


use App\Alternatives;
use App\Categories;
use App\Countries;
use App\Currencies;
use App\Departments;
use App\Orders;
use App\Positions;
use App\Units;
use App\User;
use App\Vehicles;
use App\Purchase;
use App\Reports;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Image;

use Illuminate\Support\Facades\View;

class DirectorController extends HomeController
{
    //directors
    //show
    public function get_directors() {
        $directors = User::leftJoin('Departments as a', 'users.auditor', '=', 'a.id')->where(['users.deleted'=>0, 'users.DepartmentID'=>5])->select('users.id', 'users.name', 'users.surname', 'users.email', 'users.created_at', 'a.Department')->paginate(30);

        return view('backend.directors')->with(['directors'=>$directors]);
    }

    //delete
    public function post_delete_director(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'row_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id not found!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();
            User::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Director deleted!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Director could not be deleted!']);
        }
    }

    //add
    public function get_add_director() {
        $departments = Departments::where(['deleted'=>0])->select('id', 'Department')->get();

        return view('backend.director_add')->with(['departments'=>$departments]);
    }

    public function post_add_director(Request $request) {
        $validator = Validator::make($request->all(), [
            'auditor' => 'required|integer',
            'name' => 'required|string|max:191',
            'surname' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            $slug = str_slug($request->name.'-'.$request->surname.'-'.microtime());

            $pass = bcrypt($request->password);
            unset($request['password']);

//            if (isset($request->auditor) && !empty($request->auditor)) {
//                $auditor = $request->auditor;
//            }
//            else {
//                $auditor = null;
//            }

            $request->merge(['slug'=>$slug, 'deleted'=>0, 'confirmed'=>1, 'password'=>$pass, 'auditor'=>$request->auditor, 'DepartmentID'=>5]);

            User::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Director added!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Director could not be added!']);
        }
    }

    //update
    public function get_update_director($id) {
        $departments = Departments::where(['deleted'=>0])->select('id', 'Department')->get();
        $director = User::where(['id'=>$id, 'deleted'=>0, 'DepartmentID'=>5])->select('id', 'auditor', 'name', 'surname', 'email')->first();

        return view('backend.director_update')->with(['departments'=>$departments, 'director'=>$director]);
    }

    public function post_update_director($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'auditor' => 'required|integer',
            'name' => 'required|string|max:191',
            'surname' => 'required|string|max:191',
            //'email' => 'required|email|max:191|unique:users,id,'.$id,
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fill in the required fields!']);
        }
        try {
            unset($request['_token']);

            if (!empty($request->password)) {
                $pass = bcrypt($request->password);
                unset($request['password']);
                $request->merge(['password'=>$pass]);
            }
            else {
                unset($request['password']);
            }

            User::where('id', $id)->update($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Director updated!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Director could not be updated!']);
        }
    }
    
    
    
    //show orders
    public function get_orders()
    {
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

        return view('backend.orders_for_director')->with(['units' => $units, 'vehicles' => $vehicles, 'positions' => $positions]);
    }

    //post order for user
    public function post_order(Request $request)
    {
        if ($request->type == 1) {
            //delete
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

                if ($delete_order) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                    sizin '" . $user['Product'] . "' adlı sifarişiniz direktor tərəfindən silinmişdir.";
                    $title = 'Sifarişin silinməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş silindi!', 'row_id' => $request->row_id]);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş silinərkən səhv baş verdi!']);
            }
        } else if ($request->type == 2) {
            //get orders
            $validator = Validator::make($request->all(), [
                'cat_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Kateqoriya tapılmadı!']);
            }

            $purchases = Purchase::where(['deleted'=>0])->select('AlternativeID')->distinct()->get();
            $alternatives = Alternatives::whereIn('id', $purchases)->where(['deleted'=>0])->select('OrderID')->get();

            $orders = Alternatives::leftJoin('Orders as o', 'lb_Alternatives.OrderID', '=', 'o.id')->leftJoin('lb_status as s', 'o.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'o.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'o.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'o.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'o.position_id', '=', 'p.id')->whereNotIn('o.id', $alternatives)->whereNull('lb_Alternatives.DirectorRemark')->where(['o.deleted' => 0, 'o.category_id' => $request->cat_id, 'lb_Alternatives.deleted'=>0, 'lb_Alternatives.confirm_chief'=>1])->orderBy('o.id', 'DESC')->select('o.id', 'o.Product', 'o.Translation_Brand', 'o.Part', 'o.WEB_link', 'o.image', 'u.Unit', 'o.Pcs', 's.status', 's.color', 'o.Remark', 'c.process', 'v.Marka', 'p.position', 'o.category_id', 'o.deffect_doc', 'o.created_at')->distinct()->get();

            return response(['case' => 'success', 'orders' => $orders, 'category_id' => $request->cat_id]);
        } else if ($request->type == 3) {
            //get remark
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadı!']);
            }

            $order = Orders::where(['id' => $request->id])->select('Remark')->first();

            return response(['case' => 'success', 'data' => $order['Remark']]);
        } else if ($request->type == 4) {
            //get image
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadı!']);
            }

            $order = Orders::where(['id' => $request->id])->select('image')->first();
            $image = '<img src="' . $order->image . '"  width="200" height="200">';

            return response(['case' => 'success', 'data' => $image]);
        } else if ($request->type == 5) {
            //free
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
        else if ($request->type == 6) {
            //show alternatives
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş tapılmadı!']);
            }
            $order_id = $request->order_id;

            $alternatives = Alternatives::leftJoin('lb_countries as c', 'lb_Alternatives.country_id', '=', 'c.id')->leftJoin('companies', 'lb_Alternatives.company_id', '=', 'companies.id')->leftJoin('lb_currencies_list as cur', 'lb_Alternatives.currency_id', '=', 'cur.id')->leftJoin('lb_units_list as u', 'lb_Alternatives.unit_id', '=', 'u.id')->where(['lb_Alternatives.OrderID'=>$order_id, 'lb_Alternatives.deleted'=>0, 'lb_Alternatives.confirm_chief'=>1])->select('lb_Alternatives.Brend', 'lb_Alternatives.Model', 'lb_Alternatives.PartSerialNo', 'lb_Alternatives.total_cost', 'lb_Alternatives.pcs', 'u.Unit', 'lb_Alternatives.date', 'c.country_name as country', 'lb_Alternatives.store_type', 'lb_Alternatives.id as alternative_id', 'cur.cur_name as currency', 'companies.name as company')->get();

            return response(['case' => 'success', 'alternatives'=>$alternatives, 'order_id'=>$request->order_id]);
        }
        else if ($request->type == 7) {
            //alternative add to purchase (create purchase)
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

                $request->merge(['deleted'=>0]);

                Purchase::create($request->all());

                $deadline = Carbon::now();

                Orders::where(['id'=>$order_id])->update(['situation_id'=>5, 'deadline'=>$deadline]); //Alımlara əlavə olundu

                //send email to user
                $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email = $user['email'];
                $to = $user['name'] . ' ' . $user['surname'];
                $message = $user['name'] . " " . $user['surname'] . ",
                    sizin '" . $user['Product'] . "' adlı sifarişiniz alımlara əlavə edilmişdir, hüquq şöbəsinə göndərilməsi üçün təchizat şöbəsində gözləyir.";
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

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Alternativ əlavə edildi!']);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Alternativ əlavə edilərkən səhv baş verdi!']);
            }
        }
        else if ($request->type == 8) {
            //cancel alternatives
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
                Orders::where(['id'=>$order_id])->update(['situation_id'=>$status_id]);

                //send email to user
                $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email = $user['email'];
                $to = $user['name'] . ' ' . $user['surname'];
                $message = $user['name'] . " " . $user['surname'] . ",
                    sizin '" . $user['Product'] . "' adlı sifarişiniz direktor tərəfindən təchizatçıya geri göndərilmişdir.</br>
                    Direktorun qeydi:</br>".$remark;
                $title = 'Sifarişin təchizatçıya geri göndərilməsi';

                app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);

                //send email to supply chief
                $suplly_chief = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['d.authority_id'=>4, 'users.chief'=>1])->select('users.name', 'users.surname', 'users.email')->first();

                $email2 = $suplly_chief['email'];
                $to2 = $suplly_chief['name'] . ' ' . $suplly_chief['surname'];
                $message2 = $suplly_chief['name'] . " " . $suplly_chief['surname'] . ",
                    '" . $user['Product'] . "' adlı sifariş direktor tərəfindən təchizatçıya geri göndərilmişdir.</br>
                    Direktorun qeydi:</br>".$remark;
                $title2 = 'Sifarişin təchizatçıya geri göndərilməsi';

                app('App\Http\Controllers\MailController')->get_send($email2, $to2, $title2, $message2);

                //send email to supply
                $supply = Orders::leftJoin('users as u', 'Orders.SupplyID', '=', 'u.id')->where(['Orders.id'=>$order_id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                $email3 = $supply['email'];
                $to3 = $supply['name'] . ' ' . $supply['surname'];
                $message3 = $supply['name'] . " " . $supply['surname'] . ",
                    '" . $supply['Product'] . "' adlı sifariş direktor tərəfindən təchizatçıya geri göndərilmişdir.</br>
                    Direktorun qeydi:</br>".$remark;
                $title3 = 'Sifarişin təchizatçıya geri göndərilməsi';

                app('App\Http\Controllers\MailController')->get_send($email3, $to3, $title3, $message3);

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Uğurlu!']);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
            }
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

}
