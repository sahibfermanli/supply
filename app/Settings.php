<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $fillable = ['send_email', 'message', 'message_color', 'deleted', 'deleted_at'];
}
