<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;

class Administrator extends Model {
    use Notifiable;

    public function user(): MorphOne {
        return $this->morphOne(User::class, 'userable');
    }
}
