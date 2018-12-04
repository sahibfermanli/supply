<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $table = "lb_units_list";
    protected $fillable = ['Unit', 'Remark', 'deleted', 'deleted_at', 'use_count'];
}
