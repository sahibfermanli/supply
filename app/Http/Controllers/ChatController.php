<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends HomeController
{
    public function get_chat() {
        return view('backend.chat');
    }
}
