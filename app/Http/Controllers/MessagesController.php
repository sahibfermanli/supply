<?php

namespace App\Http\Controllers;

use App\Messages;
use App\MessageUser;
use App\Orders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessagesController extends HomeController
{
    public function get_messages()
    {
        try {
            if (Auth::user()->authority() == 4 && Auth::user()->chief() == 1) {
                //SupplyChief
                $messages = Orders::whereNotNull('message')->where(['deleted'=>0])->orderBy('message_date', 'DESC')->select('id as order_id', 'Product', 'message', 'message_date', 'message_id', 'message_author')->distinct()->limit(50)->get();
            }
            else if (Auth::user()->authority() == 5 || Auth::user()->authority() == 8) {
                //Director
                $messages = Orders::whereNotNull('message')->where(['deleted'=>0])->orderBy('message_date', 'DESC')->select('id as order_id', 'Product', 'message', 'message_date', 'message_id', 'message_author')->distinct()->limit(50)->get();
            }
            else if (Auth::user()->authority() == 4 && Auth::user()->chief() != 1) {
                //SupplyUser
                $messages = Orders::whereNotNull('message')->where(['SupplyID'=>Auth::id(), 'deleted'=>0])->orderBy('message_date', 'DESC')->select('id as order_id', 'Product', 'message', 'message_date', 'message_id', 'message_author')->distinct()->limit(50)->get();
            }
            else {
                //User or UserChief
                $messages = Orders::whereNotNull('message')->where(['DepartmentID'=>Auth::user()->DepartmentID(), 'deleted'=>0])->orderBy('message_date', 'DESC')->select('id as order_id', 'Product', 'message', 'message_date', 'message_id', 'message_author')->distinct()->limit(50)->get();
            }

            $i = 0;
            foreach ($messages as $message) {
                if (MessageUser::where(['user_id'=>Auth::id(), 'message_id'=>$message->message_id, 'viewed'=>1, 'deleted'=>0])->count() > 0) {
                    $messages[$i]['viewed'] = 1;
                } else {
                    $messages[$i]['viewed'] = 0;
                }
                $i++;
            }

            return view("backend.chat")->with(['messages'=>$messages]);
        } catch (\Exception $e) {
            return redirect("/");
        }
    }

    public function post_messages(Request $request) {
        if ($request->type == 'show_messages') {
            return $this->show_messages($request);
        }
        else if ($request->type == 'add_message') {
            return $this->add_message($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Oops!', 'content' => 'Səhv baş verdi!']);
        }
    }

    private function add_message(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'message' => 'required|string|max:5000',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Məlumatlar tam deyil!']);
        }
        try {
            $order_id = $request->order_id;

            if (Auth::user()->authority() == 3) {
                //User
                if (Orders::where(['id'=>$order_id, 'DepartmentID'=>Auth::user()->DepartmentID(), 'deleted'=>0])->count() == 0) {
                    return response(['case' => 'error', 'title' => 'Oops!', 'content' => 'Sizin bu əməliyyat üçün icazəniz yoxdur!']);
                }
            }

            $request->merge(['author'=>Auth::id()]);

            Messages::create($request->all());

            $added_date = (string) Carbon::now();

            return response(['case' => 'success', 'type'=>'new_message', 'added_message'=>$request->message, 'added_date'=>$added_date, 'order_id'=>$request->order_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    private function show_messages(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Mesaj tapılmadı!']);
        }
        try {
            $order_id = $request->order_id;

            if (Auth::user()->authority() == 3) {
                //User
                if (Orders::where(['id'=>$order_id, 'DepartmentID'=>Auth::user()->DepartmentID(), 'deleted'=>0])->count() == 0) {
                    return response(['case' => 'error', 'title' => 'Oops!', 'content' => 'Sizin bu mesajları görmək üçün icazəniz yoxdur!']);
                }
            }

            if ($request->message_id != null && MessageUser::where(['user_id'=>Auth::id(), 'message_id'=>$request->message_id, 'deleted'=>0])->count() == 0) {
                MessageUser::create(['user_id'=>Auth::id(), 'message_id'=>$request->message_id, 'viewed'=>1]);
            }
//            Messages::where(['order_id'=>$order_id, 'deleted'=>0, 'viewed'=>0])->update(['viewed'=>1, 'viewed_at'=>Carbon::now()]);
            $messages = Messages::leftJoin('users as u', 'messages.author', '=', 'u.id')->where(['messages.order_id'=>$order_id, 'messages.deleted'=>0])->select('messages.id', 'messages.message', 'messages.author', 'messages.created_at', 'u.name', 'u.surname')->get();

            return response(['case' => 'success', 'messages'=>$messages]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
