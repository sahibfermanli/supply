<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';
    protected $fillable = ['order_id', 'status_id', 'deleted', 'deleted_at', 'deleted_by'];
}
