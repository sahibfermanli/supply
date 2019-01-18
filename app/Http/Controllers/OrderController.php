<?php

namespace App\Http\Controllers;

use App\Alternatives;
use App\Categories;
use App\Company;
use App\Countries;
use App\Currencies;
use App\Orders;
use App\Positions;
use App\Units;
use App\User;
use App\Vehicles;
use App\Reports;
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
    //show orders
    public function get_orders()
    {
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

        return view('backend.orders')->with(['units' => $units, 'vehicles' => $vehicles, 'positions' => $positions]);
    }

    public function get_orders_for_chief()
    {
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

        return view('backend.orders_for_chief')->with(['units' => $units, 'vehicles' => $vehicles, 'positions' => $positions]);
    }


    //post order for user
    public function post_delete_order(Request $request)
    {
        if ($request->type == 1) {
            //delete
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
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                    sizin '" . $user['Product'] . "' adlı sifarişiniz silinmişdir.";
                    $title = 'Sifarişin silinməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş silindi!', 'id' => $id]);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
            }
        } else if ($request->type == 2) {
            //get orders
            $validator = Validator::make($request->all(), [
                'cat_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Category not found!']);
            }

            $orders = Orders::leftJoin('lb_status as s', 'Orders.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'Orders.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'Orders.position_id', '=', 'p.id')->where(['Orders.deleted' => 0, 'Orders.category_id' => $request->cat_id, 'Orders.MainPerson' => Auth::id()])->select('Orders.id', 'Orders.position_id', 'Orders.vehicle_id', 'Orders.Product', 'Orders.Translation_Brand', 'Orders.Part', 'Orders.WEB_link', 'image', 'u.Unit', 'Orders.unit_id', 'Orders.Pcs', 's.status', 's.color', 'Orders.Remark', 'c.process', 'v.Marka', 'p.position', 'Orders.category_id', 'Orders.deffect_doc', 'Orders.created_at', 'Orders.situation_id as status_id', 'Orders.ReportDocument', 'Orders.confirmed', 'Orders.confirmed_at', 'Orders.ReportNo')->orderBy('Orders.id', 'DESC')->get();

            $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
            $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
            $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

            return response(['case' => 'success', 'orders' => $orders, 'category_id' => $request->cat_id, 'units'=>$units, 'positions'=>$positions, 'vehicles'=>$vehicles]);
        } else if ($request->type == 3) {
            //get remark
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id not found!']);
            }

            $order = Orders::where(['id' => $request->id, 'MainPerson' => Auth::id()])->select('Remark')->first();

            return response(['case' => 'success', 'data' => $order['Remark']]);
        } else if ($request->type == 4) {
            //get image
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id not found!']);
            }

            $order = Orders::where(['id' => $request->id, 'MainPerson' => Auth::id()])->select('image')->first();
            $image = '<img src="' . $order->image . '"  width="200" height="200">';

            return response(['case' => 'success', 'data' => $image]);
        }
        else if ($request->type == 5) {
            //add new order
            return $this->add_order($request);
        }
        else if ($request->type == 6) {
            //update order
            return $this->update_order($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //orders for supply
    public function get_orders_for_supply()
    {
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
        $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();
        $countries = Countries::where('deleted', 0)->select(['id', 'country_code', 'country_name'])->get();
        $currencies = Currencies::where('deleted', 0)->select(['id', 'cur_name', 'cur_value', 'cur_rate'])->get();
        $companies = Company::where('deleted', 0)->select(['id', 'name'])->orderBy('name')->get();
        $supplies = User::leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['d.authority_id'=>4, 'users.deleted'=>0])->select('users.id', 'users.name', 'users.surname')->get();

        return view('backend.orders_for_supply')->with(['units' => $units, 'companies'=>$companies, 'vehicles' => $vehicles, 'positions' => $positions, 'countries'=>$countries, 'currencies'=>$currencies, 'supplies'=>$supplies]);
    }

    //post order for supply
    public function post_delete_order_for_supply(Request $request)
    {
        if ($request->type == 1) {
            //cancel
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadl!']);
            }
            try {
                $id = $request->id;
                $cancel_order = Orders::where(['id' => $id])->update(['situation_id'=>9]); //istifadeciye geri gonderildi

                if ($cancel_order) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                    sizin <b>" . $user['Product'] . "</b> adlı sifarişiniz department rəhbəriniz tərəfindən qəbul edilmədi.";
                    $title = 'Sifarişin geri çevrilməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş geri çevrildi!', 'id' => $id]);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
            }
        } else if ($request->type == 2) {
            //empty
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Error!']);
        } else if ($request->type == 3) {
            //get remark
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'İd tapılmadı!']);
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
            $image = '<img src="' . $order->image . '"  width="400" height="200">';

            return response(['case' => 'success', 'data' => $image]);
        } else if ($request->type == 5) {
            //create alternative
            $validator = Validator::make($request->all(), [
                'OrderID' => 'required|integer',
                'unit_id' => 'required|integer',
                'Brend' => 'required|string|max:255',
                'Model' => 'required|string|max:255',
                'PartSerialNo' => 'required|string|max:255',
                'date' => 'required|date',
                'cost' => 'required',
                'country_id' => 'required|integer',
                'currency_id' => 'required|integer',
                'company_id' => 'required|integer',
                'pcs' => 'required|integer',
                'Remark' => 'required|string',
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
                $alts = Alternatives::leftJoin('lb_countries as c', 'lb_Alternatives.country_id', '=', 'c.id')->leftJoin('companies', 'lb_Alternatives.company_id', '=', 'companies.id')->leftJoin('lb_currencies_list as cur', 'lb_Alternatives.currency_id', '=', 'cur.id')->leftJoin('lb_units_list as u', 'lb_Alternatives.unit_id', '=', 'u.id')->where(['lb_Alternatives.OrderID'=>$request->OrderID, 'lb_Alternatives.deleted'=>0])->orderBy('lb_Alternatives.id', 'DESC')->select('lb_Alternatives.*', 'u.Unit', 'c.country_name as country', 'cur.cur_name as currency', 'companies.name as company')->first();

                Orders::where(['id'=>$order_id])->update(['situation_id'=>8]); //Alternativ yaradilib

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Alternativ əlavə edildi!', 'order_id' => $order_id, 'type' => 'add_alternative', 'alts'=>$alts]);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Alternativ əlavə edilərkən səhv baş verdi!']);
            }
        }
        else if ($request->type == 6) {
            //get orders
            $validator = Validator::make($request->all(), [
                'cat_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Kateqoriya tapılmadl!']);
            }

            if (Auth::user()->chief() == 1) {
                $orders = Orders::leftJoin('lb_status as s', 'Orders.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'Orders.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'Orders.position_id', '=', 'p.id')->leftJoin('users', 'Orders.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->leftJoin('users as supply', 'Orders.SupplyID', '=', 'supply.id')->where(['Orders.deleted' => 0, 'Orders.category_id' => $request->cat_id])->where(function ($query){$query->where('Orders.confirmed', '=', 1)->orWhere('Orders.DepartmentID', '=', Auth::user()->DepartmentID());})->select('Orders.id', 'Orders.Product', 'Orders.Translation_Brand', 'Orders.Part', 'Orders.WEB_link', 'image', 'u.Unit', 'Orders.Pcs', 's.status', 's.color', 'Orders.Remark', 'c.process', 'v.Marka as vehicle', 'v.QN', 'v.Tipi', 'p.position', 'Orders.category_id', 'Orders.deffect_doc', 'Orders.created_at', 'Orders.SupplyID', 'supply.name as supply_name', 'supply.surname as supply_surname', 'Orders.situation_id as status_id', 'Orders.vehicle_id', 'Orders.unit_id', 'Orders.position_id', 'Orders.ReportDocument', 'Orders.confirmed', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as user_department')->get();
            }
            else {
                $orders = Orders::leftJoin('lb_status as s', 'Orders.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'Orders.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'Orders.position_id', '=', 'p.id')->leftJoin('users', 'Orders.MainPerson', '=', 'users.id')->leftJoin('Departments as d', 'users.DepartmentID', '=', 'd.id')->where(['Orders.deleted' => 0, 'Orders.category_id' => $request->cat_id])->where(function ($query){$query->where('Orders.SupplyID', '=', Auth::id())->orWhere('Orders.MainPerson', '=', Auth::id());})->select('Orders.id', 'Orders.Product', 'Orders.Translation_Brand', 'Orders.Part', 'Orders.WEB_link', 'image', 'u.Unit', 'Orders.Pcs', 's.status', 's.color', 'Orders.Remark', 'c.process', 'v.Marka', 'p.position', 'Orders.category_id', 'Orders.deffect_doc', 'Orders.created_at', 'Orders.SupplyID', 'Orders.situation_id as status_id', 'Orders.vehicle_id', 'Orders.unit_id', 'Orders.position_id', 'Orders.ReportDocument', 'Orders.confirmed', 'users.name as user_name', 'users.surname as user_surname', 'd.Department as user_department')->get();
            }

            $purchases = Purchase::leftjoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->where(['Purchases.deleted'=>0])->select('a.OrderID')->get();

            $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
            $vehicles = Vehicles::orderBy('QN')->select(['id', 'QN', 'Marka', 'Tipi'])->get();
            $positions = Positions::where(['deleted' => 0])->orderBy('position')->select('id', 'position')->get();

            return response(['case' => 'success', 'orders' => $orders, 'category_id' => $request->cat_id, 'purchases'=>$purchases, 'units'=>$units, 'vehicles'=>$vehicles, 'positions'=>$positions]);
        }
        else if ($request->type == 7) {
            //add new order
            return $this->add_order($request);
        }
        else if ($request->type == 8) {
            //show alternative
            $alternatives = Alternatives::leftJoin('lb_countries as c', 'lb_Alternatives.country_id', '=', 'c.id')->leftJoin('companies', 'lb_Alternatives.company_id', '=', 'companies.id')->leftJoin('lb_currencies_list as cur', 'lb_Alternatives.currency_id', '=', 'cur.id')->leftJoin('lb_units_list as u', 'lb_Alternatives.unit_id', '=', 'u.id')->where(['lb_Alternatives.OrderID'=>$request->order_id, 'lb_Alternatives.deleted'=>0])->select('lb_Alternatives.*', 'u.Unit', 'c.country_name as country', 'cur.cur_name as currency', 'companies.name as company', 'suggestion')->get();
            $order = Orders::where(['id'=>$request->order_id])->select('Product', 'Translation_Brand', 'Part')->first();

            return response(['case'=>'success', 'alternatives'=>$alternatives, 'order'=>$order]);
        }
        else if ($request->type == 9) {
            //select supply for order
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

            return response(['case'=>'success', 'title'=>'Uğurlu!', 'content'=>'Təchizatçı uğurla seçildi.', 'type'=>'add_order', 'category_id'=>$cat_id]);
        }
        else if ($request->type == 10) {
            if (Auth::user()->chief() == 0) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sizin bu əməliyyat üçün hüququnuz yoxdur!']);
            }

            //confirm alternative for chief supply
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

                if (Orders::where(['id'=>$order_id, 'situation_id'=>10, 'deleted'=>0])->count() == 0) {
                    Orders::where(['id'=>$order_id])->update(['situation_id'=>10]); //direktora gonderilib

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

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Təsdiq edildi!']);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
            }
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
        else {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Error!']);
        }
    }

    //post order for chief
    public function post_delete_order_for_chief(Request $request)
    {
        if ($request->type == 1) {
            //cancel
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadl!']);
            }
            try {
                $id = $request->id;
                $cancel_order = Orders::where(['id' => $id])->update(['situation_id'=>9]); //istifadeciye geri gonderildi

                if ($cancel_order) {
                    $user = Orders::leftJoin('users as u', 'Orders.MainPerson', '=', 'u.id')->where(['Orders.id'=>$id])->select('u.name', 'u.surname', 'u.email', 'Orders.Product')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = $user['name'] . " " . $user['surname'] . ",
                    sizin <b>" . $user['Product'] . "</b> adlı sifarişiniz department rəhbəriniz tərəfindən qəbul edilmədi.";
                    $title = 'Sifarişin geri çevrilməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }

                return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş geri çevrildi!', 'id' => $id]);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
            }
        } else if ($request->type == 2) {
            //get orders
            $validator = Validator::make($request->all(), [
                'cat_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Kateqoriya tapılmadı!']);
            }

            $orders = Orders::leftJoin('users', 'Orders.MainPerson', '=', 'users.id')->leftJoin('lb_status as s', 'Orders.situation_id', '=', 's.id')->leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->leftJoin('lb_categories as c', 'Orders.category_id', '=', 'c.id')->leftJoin('lb_vehicles_list as v', 'Orders.vehicle_id', '=', 'v.id')->leftJoin('lb_positions as p', 'Orders.position_id', '=', 'p.id')->where(['Orders.deleted' => 0, 'Orders.category_id' => $request->cat_id, 'Orders.DepartmentID' => Auth::user()->DepartmentID()])->select('Orders.id', 'Orders.Product', 'Orders.Translation_Brand', 'Orders.Part', 'Orders.WEB_link', 'image', 'u.Unit', 'Orders.unit_id', 'Orders.Pcs', 's.status', 's.color', 'Orders.Remark', 'c.process', 'v.Marka', 'p.position', 'Orders.category_id', 'Orders.deffect_doc', 'Orders.created_at', 'Orders.situation_id as status_id', 'Orders.confirmed', 'Orders.confirmed_at' , 'Orders.ReportDocument', 'Orders.ReportNo', 'Orders.confirmed_at', 'users.name as user_name', 'users.surname as user_surname')->orderBy('Orders.id', 'DESC')->get();

            $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();

            return response(['case' => 'success', 'orders' => $orders, 'category_id' => $request->cat_id, 'units'=>$units]);

        } else if ($request->type == 3) {
            //get remark
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Id tapılmadı!']);
            }

            $order = Orders::where(['id' => $request->id, 'DepartmentID' => Auth::user()->DepartmentID()])->select('Remark')->first();

            return response(['case' => 'success', 'data' => $order['Remark']]);
        } else if ($request->type == 4) {
            //get image
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'İd tapılmadı!']);
            }

            $order = Orders::where(['id' => $request->id, 'DepartmentID' => Auth::user()->DepartmentID()])->select('image')->first();
            $image = '<img src="' . $order->image . '"  width="200" height="200">';

            return response(['case' => 'success', 'data' => $image]);
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
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //get alternative image
    public function get_alt_image(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
        }

        $alt = Alternatives::where(['id' => $request->id])->select('image')->first();
        $image = '<img src="' . $alt->image . '"  width="200" height="200">';

        return response(['case' => 'success', 'data' => $image]);
    }

    //delete alternative
    public function delete_alternative(Request $request) {
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
    public function suggestion_alternative(Request $request) {
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

    public function confirm_order(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş tapılmadı!']);
        }

        try {
            $arr = array();
            $order_id = $request->order_id;
            $arr['ChiefID'] = Auth::id();
            $arr['confirmed_at'] = Carbon::now();
            $arr['confirmed'] = 1;
            $arr['situation_id'] = 2; //tesdiqlendi

            $confirm_order = Orders::where(['id'=>$order_id, 'deleted'=>0])->update($arr);

            if ($confirm_order) {
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

            return response(['case' => 'success', 'order_id'=>$order_id, 'cat_id'=>$request->cat_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş təsdiq edilərkən səhv baş verdi!']);
        }
    }

    public function add_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Product' => 'required|string|max:300',
            'Pcs' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Lazımlı xanaları doldurun!']);
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

            $situation_id = 1; //pending

            $request->merge(['deleted' => 0, 'MainPerson' => Auth::id(), 'DepartmentID' => Auth::user()->DepartmentID(), 'situation_id' => $situation_id]);

            unset($request['picture']);
            $request = Input::except('picture');

            unset($request['defect']);
            $request = Input::except('defect');

            unset($request['report']);
            $request = Input::except('report');

            unset($request['type']);

            $add_order = Orders::create($request);

            if ($add_order) {
                Units::where('id', $unit_id)->increment('use_count');

                $user = User::where(['DepartmentID'=>Auth::user()->DepartmentID(), 'chief'=>1, 'deleted'=>0])->select('name', 'surname', 'email')->first();
                $category = Categories::where(['id'=>$cat_id])->select('process')->first();

                $email = $user['email'];
                $to = $user['name'] . ' ' . $user['surname'];
                $message = $user['name'] . " " . $user['surname'] . ",
                    yeni sifariş var. </br>
                    Sifarişi verən: ". Auth::user()->name." ".Auth::user()->surname .".</br>
                    Sifariş: ". $product .".</br>
                    Sifarşin kateqoriyası: ". $category->process .".
                    ";
                $title = 'Yeni sifariş';

                app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş yaradıldı!', 'type'=>'add_order', 'category_id'=>$cat_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifariş yaradılarkən səhv baş verdi!']);
        }
    }

    public function update_order(Request $request)
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
    public function update_order_image(Request $request) {
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

    //add new report
    public function add_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'mimes:doc,docx,pdf|required',
            'Subject' => 'required|string|max:200',
            'Text' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Lazımlı xanaları doldurun!']);
        }

        $file = Input::file('file');
        $file_ext = $file->getClientOriginalExtension();
        $file_name = 'report_' . str_random(4) . '.' . $file_ext;
        Storage::disk('uploads')->makeDirectory('files/reports');
        $file->move('uploads/files/reports/', $file_name);
        $file_address = '/uploads/files/reports/' . $file_name;

        try {
            $mainPerson = Auth::id();
            $departmentId = Auth::user()->DepartmentID();
            $reportDocument = $file_address;
            $status_id = 1; //pending

            unset($request['file']);
            $request->merge(['MainPerson' => $mainPerson, 'DepartmentId' => $departmentId, 'deleted' => 0, 'ReportDocument' => $reportDocument, 'status_id'=>$status_id]);

            unset($request['type']);

            $add = Reports::create($request->all());

            return $add->id;
        } catch (\Exception $e) {
            return false;
        }
    }

    //add orders to report (report_id add to orders)
    public function orders_add_to_report($report_id, $orders_str) {
      $success = 0;
      $error = 0;
      $situation_id = 2; //raporta elave edildi

      // if ($report_id == 0 || !ctype_digit($report_id)) {
      //     return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Raport tapilmadi!']);
      // }

      $orders = explode(',', $orders_str);

      if (count($orders) == 0) {
          return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Sifaris tapilmadi!']);
      }
      for ($i=0; $i<count($orders); $i++) {
          if (ctype_digit($orders[$i]) && $orders[$i] != 0) {
              $update = Orders::where(['id'=>$orders[$i], 'deleted'=>0, 'ReportID'=>null])->update(['ReportID'=>$report_id, 'situation_id'=>$situation_id]);
              if ($update) {
                  $success++;
              }
              else {
                  $error++;
              }
          }
          else {
              $error++;
          }
      }

      return response(['case' => 'success', 'title' => 'Başa çatdı!', 'type'=>'add_order_to_report', 'orders'=>$orders, 'content' => $success.' uğurlu; '.$error.' xəta.']);
    }
}
