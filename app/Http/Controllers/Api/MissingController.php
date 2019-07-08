<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Users as UsersResource;

class MissingController extends ApiController
{
    public function not_found() {
        $response_arr['status'] = 404;
        $response_arr['message'] = "User not found. Check that you entered your information correctly.";

        $response_obj = (object) $response_arr;

        return new UsersResource($response_obj);
    }
}
