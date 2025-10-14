<?php

namespace Modules\Employees\Models\Traits;

trait HasEmployeeHelpers {
    public function getFullNameAttribute(): string {
        return implode(' ', array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
        ], fn($value) => !empty($value)));
    }
}
