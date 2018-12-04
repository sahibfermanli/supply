<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = ['name', 'address', 'account_number', 'zip_code', 'phone', 'local', 'deleted', 'deleted_at'];
}
