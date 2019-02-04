<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sellers extends Model
{
    protected $table = "lb_sellers";
    protected $fillable = ['seller_name', 'seller_director', 'seller_voen', 'seller_account_no', 'bank_name', 'bank_voen', 'bank_code', 'bank_m_n', 'bank_swift', 'contract_no', 'contract_date', 'edited_ip', 'deleted', 'deleted_at'];
}
