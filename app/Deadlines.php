<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deadlines extends Model
{
    protected $table = "deadlines";
    protected $fillable = ['deadline', 'color', 'deleted', 'deleted_at', 'type'];
}
