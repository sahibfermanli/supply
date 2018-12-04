<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends HomeController
{
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
                User::where('id', $request->id)->update(['confirmed' => 1]);
//                $seller = User::where('id', $request->id)->select()->first();
//                $email = $seller['email'];
//                $to = $seller['name']." ".$seller['surname'];
//                $message = "Hörmətli, ".$seller['name']." ".$seller['surname']."! Sizin, <a href='https://stock.arshinmall.com'>https://stock.arshinmall.com</a> saytindakı hesabınız təsdiqləndi. Hesabınıza giriş edə bilərsiniz...";
//                $title = 'Hesabınız təsdiqləndi';
//                app('App\Http\Controllers\MailController')->get_send($email, $to, $title, $message);
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
