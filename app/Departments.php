<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'Departments';
    protected $fillable = ['Department', 'Company', 'authority_id', 'deleted', 'deleted_at'];
}
