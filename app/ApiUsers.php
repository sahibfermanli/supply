<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiUsers extends Model
{
    protected $table = "api_users";
    protected $fillable = [
        'username',
        'password',
        'deleted',
        'deleted_at'
    ];
}
