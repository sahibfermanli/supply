<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlternativeLogs extends Model
{
    protected $table = 'alternative_logs';
    protected $fillable = ['alt_id', 'user_id', 'type', 'deleted', 'deleted_at'];
}
