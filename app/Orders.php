<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'Orders';
    protected $fillable = ['Product', 'Translation_Brand', 'Part', 'WEB_link', 'image', 'unit_id', 'Pcs', 'Remark', 'deleted', 'deleted_at', 'MainPerson', 'DepartmentID', 'category_id', 'vehicle_id', 'position_id', 'deffect_doc', 'SupplyID', 'deadline', 'confirmed', 'ChiefID', 'confirmed_at', 'ReportDocument', 'ReportNo', 'delivered_person', 'residual', 'delivered', 'delivered_at', 'last_status_id'];
}
