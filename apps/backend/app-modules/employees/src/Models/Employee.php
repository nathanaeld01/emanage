<?php

namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Modules\Employees\Models\Traits\HasEmployeeHelpers;
use Modules\Employees\Models\Traits\HasEmployeeRelations;

class Employee extends Model {
    use Notifiable, Searchable;
    use HasEmployeeRelations, HasEmployeeHelpers;

    protected $fillable = [
        'employee_code',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'personal_email',
        'profile_photo',
        'department_id',
        'designation_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'department_id',
        'designation_id',
    ];

    protected $appends = [
        'full_name'
    ];

    public function toSearchableArray(): array {
        return [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'employee_code' => $this->employee_code,
            'email' => $this->email,
        ];
    }
}
