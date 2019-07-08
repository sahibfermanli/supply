<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Users extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }

    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'author' => 's.fermanli'
        ];
    }
}
