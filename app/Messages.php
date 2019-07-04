<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'message',
        'order_id',
        'author',
        'deleted',
        'deleted_at'
    ];
}
