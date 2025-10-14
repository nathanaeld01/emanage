<?php

namespace App\Models\Traits;

trait HasUserHelpers {
    public function isEmployee(): bool {
        return $this->userable_type === 'employee';
    }

    public function isClient(): bool {
        return $this->userable_type === 'client';
    }

    public function isAdministrator(): bool {
        return $this->userable_type === 'administrator';
    }
}
