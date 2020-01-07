<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demands extends Model
{
    protected $table = 'demands';
    protected $fillable = ['created_by', 'deleted', 'deleted_at', 'company_id'];
}
