<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = "lb_categories";
    protected $fillable = ['process', 'deleted', 'deleted_at', 'ctgr', 'orders_count'];
}
