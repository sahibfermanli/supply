<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = "lb_positions";
    protected $fillable = ['position', 'deleted', 'deleted_at'];
}
