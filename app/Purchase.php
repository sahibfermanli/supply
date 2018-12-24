<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = "Purchases";
    protected $fillable = ['AlternativeID', 'qaime_doc', 'qaime_date', 'qaime_no', 'Remark', 'status_id', 'deleted', 'deleted_at', 'completed', 'completed_at', 'account_id'];
}
