<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasUserRelations {
    public function user() {
        return $this->morphOne(User::class, 'userable');
    }
}
