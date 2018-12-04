<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Situations extends Model
{
    protected $table = 'lb_status';
    protected $fillable = ['status', 'color', 'deleted', 'deleted_at'];
}
