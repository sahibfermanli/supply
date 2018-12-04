<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $table = "lb_vehicles_list";
    protected $fillable = ['Marka', 'QN', 'Tipi', 'SN'];
}
