<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = "Purchases";
    protected $fillable = ['AlternativeID', 'muqavile_doc', 'muqavile_doc_date', 'hesab_doc', 'hesab_doc_date', 'odenish_date', 'qaime_doc', 'qaime_doc_date', 'AWB_Akt_doc', 'AWB_Akt_doc_date', 'icrachi_doc', 'icrachi_doc_date', 'company_id', 'delivery_person_id', 'delivery_date', 'Verilib_MHIS', 'Verilib_MHIS_date', 'Remark', 'status_id', 'deleted', 'deleted_at'];
}
