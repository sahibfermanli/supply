<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Categories;
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

    public function get_index() {
//        $email = ['sfermanli@swgh.az', 'sahibfermanli230@gmail.com'];
//        $to = ['Sahib Fermanli', 'Gmail Com'];
//        $message = "Azerbaycan";
//        $title = 'Azerbaycan';
//
//        app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);

        return view('backend.index');
    }
}
