<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $table = 'accounts';
    protected $fillable = ['account_no', 'account_doc', 'company', 'deleted', 'deleted_at', 'send', 'send_at', 'lawyer_confirm', 'lawyer_confirm_at', 'lawyer_remark', 'lawyer_chief_confirm', 'lawyer_chief_confirm_at', 'finance_confirm', 'finance_confirm_at', 'finance_chief_confirm', 'finance_chief_confirm_at'];
}
