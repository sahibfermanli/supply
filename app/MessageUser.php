<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageUser extends Model
{
    protected $table = 'message_user';
    protected $fillable = [
        'user_id',
        'message_id',
        'viewed',
        'deleted',
        'deleted_at'
    ];
}
