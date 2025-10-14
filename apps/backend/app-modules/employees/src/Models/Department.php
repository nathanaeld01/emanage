<?php

namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {
    protected $fillable = [
        'department_name',
        'alias',
        'type',
    ];
}
