<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends HomeController
{
    //reset password
    public function get_reset_password() {
        if (User::where(['id'=>Auth::id(), 'password_reset'=>1])->count() > 0) {
            return redirect('/');
        }

        return view('backend.reset_password');
    }

    public function post_reset_password(Request $request) {
        if (User::where(['id'=>Auth::id(), 'password_reset'=>1])->count() > 0) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'confirm_password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Bütün məlumatları daxil edin!']);
        }
        try {
            if ($request->password != $request->confirm_password) {
                Session::flash('message', 'Daxil edilən şifrələr eyni deyil!');
                Session::flash('class', 'warning');
                Session::flash('display', 'block');
                return redirect('/reset-password');
            }

            $password = bcrypt($request->password);

            User::where(['id'=>Auth::id()])->update(['password'=>$password, 'password_reset'=>1]);

            return redirect('/logout');
        } catch (\Exception $e) {
            Session::flash('message', 'Səhv baş verdi!');
            Session::flash('class', 'danger');
            Session::flash('display', 'block');
            return redirect('/reset-password');
        }
    }

    //show
    public function get_users() {
        $users = User::where(['deleted'=>0, 'chief'=>0, 'DepartmentID'=>Auth::user()->DepartmentID()])->orderBy('confirmed')->orderBy('name')->select('id', 'name', 'surname', 'email', 'confirmed', 'created_at', 'updated_at')->paginate(30);

        return view('backend.users')->with(['users'=>$users]);
    }

    //delete or approve
    public function post_delete_or_approve_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'row_id' => 'required|integer',
            'type' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id not found!']);
        }
        try {
            if ($request->type == 1) {
                //delete
                User::where('id', $request->id)->update(['deleted' => 1]);
                return response(['case' => 'success', 'title' => 'Success!', 'content' => 'User deleted!', 'row_id'=>$request->row_id]);
            }
            else if ($request->type == 2) {
                //approve
                $confirm_user = User::where('id', $request->id)->update(['confirmed' => 1]);

                if ($confirm_user) {
                    $user = User::where('id', $request->id)->select('name', 'surname', 'email')->first();

                    $email = $user['email'];
                    $to = $user['name'] . ' ' . $user['surname'];
                    $message = "
                    Hörmətli istifadəçi, sizin hesabınız təsdiqlənmişdir.</br> 
                    E-mail və şifrənizi daxil edərək sistemə daxil ola bilərsiniz.</br>
                    Link: <a target='_blank' href='https://supply.swgh.az'>https://supply.swgh.az</a></br>
                    Sizin e-mail adresiniz: ". $user['email'];
                    $title = 'Hesabın təsdiqlənməsi';

                    app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
                }

                return response(['case' => 'success', 'title' => 'Success!', 'content' => 'User approved!', 'row_id' => $request->row_id]);
            }
            else {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'An error occurred!']);
            }
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'An error occurred!']);
        }
    }

    //update user information

    public function get_users_update() {
        return view('backend.users_update');
    }

    public function post_users_update (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'surname' => 'required|string|max:191',
            'email' => 'required|email|max:191',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Lazımlı xanaları doldurun!']);
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

            User::where('id', Auth::id())->update($request->all());

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Məlumatlarınız dəyişdirildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Məlumatların dəyişdirilməsində səh baş verdi!']);
        }
    }
}
