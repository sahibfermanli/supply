<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = "lb_countries";
    protected $fillable = ['country_code', 'country_name', 'deleted', 'deleted_at'];
}
