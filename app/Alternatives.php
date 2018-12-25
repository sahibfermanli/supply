<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alternatives extends Model
{
    protected $table = "lb_Alternatives";
    protected $fillable = ['pcs', 'unit_id', 'Brend', 'Model', 'PartSerialNo', 'date', 'cost', 'company_id', 'pcs', 'Remark', 'DirectorRemark', 'OrderID', 'deleted', 'deleted_at', 'store_type', 'country_id', 'currency_id', 'confirm_chief', 'image'];
}
