<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $table = 'Reports';
    protected $fillable = ['ReportNo', 'MainPerson', 'DepartmentId', 'Subject', 'ReportDocument', 'Text', 'deleted', 'deleted_at', 'status_id'];
}
