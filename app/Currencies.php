<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    protected $table = "lb_currencies_list";
    protected $fillable = ['cur_name', 'cur_value', 'cur_rate', 'deleted', 'deleted_at'];
}
