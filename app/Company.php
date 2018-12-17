<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = ['name', 'address', 'zip_code', 'phone', 'fax', 'local', 'deleted', 'deleted_at'];
}
