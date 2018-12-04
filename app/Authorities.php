<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorities extends Model
{
    protected $table = 'authorities';
    protected $fillable = ['title', 'deleted', 'deleted_at'];
}
