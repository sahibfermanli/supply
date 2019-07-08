<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Messages as MessagesResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends ApiController
{
    public function message() {
        $response_arr['status'] = 500;
        $response_arr['type'] = 'Error';
        $response_arr['message'] = 'Sorry, An error occurred...';

        $response_obj = (object) $response_arr;

        return new MessagesResource($response_obj);
    }
}
