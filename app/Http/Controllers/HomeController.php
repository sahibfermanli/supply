<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Categories;
use App\Orders;
use App\OrderStatus;
use App\Settings;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $categories = Categories::where(['deleted'=>0])->orderBy('process')->select('id', 'process')->get();

        //settings
        $settings = Settings::where(['id'=>1])->select('message', 'message_color')->first();

        View::share(['categories'=>$categories, 'accounts'=>array(), 'settings'=>$settings]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    ///delete
//    public function create_status() {
//        $orders = Orders::select('id', 'situation_id', 'updated_at')->get();
//
//        foreach ($orders as $order) {
//            $arr['order_id'] = $order->id;
//            $arr['status_id'] = $order->situation_id;
//            $arr['date'] = $order->updated_at;
//
//            OrderStatus::create($arr);
//        }
//
//        return 'Finish!';
//    }
//
//    public function temir() {
//        return "Sistem təmir işləri ilə əlaqədar olaraq müvəqqəti olaraq işləmir. Biraz sonra yenidən cəhd edin.";
//    }

    public function get_index() {
//        $email = ['sfermanli@swgh.az', 'sahibfermanli230@gmail.com'];
//        $to = ['Sahib Fermanli', 'Gmail Com'];
//        $message = "Azerbaycan";
//        $title = 'Azerbaycan';
//
//        app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);

        //update last status
//        $orders = Orders::select('id')->get();
//        foreach ($orders as $order) {
//            if (OrderStatus::where(['order_id'=>$order->id, 'deleted'=>0])->select('status_id')->count() > 0) {
//                $statuses = OrderStatus::where(['order_id'=>$order->id, 'deleted'=>0])->select('status_id')->orderBy('id', 'Desc')->first();
//                $last_status_id = $statuses->status_id;
//                Orders::where(['id'=>$order->id])->update(['last_status_id'=>$last_status_id]);
//            }
//        }
//
//        return 'finish';

        return view('backend.index');
    }
}
