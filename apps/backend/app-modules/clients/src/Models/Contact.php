<?php

namespace Modules\Clients\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;

class Contact extends Model {
    use Notifiable;

    public function user(): MorphOne {
        return $this->morphOne(User::class, 'userable');
    }

    public function organization(): BelongsTo {
        return $this->belongsTo(Client::class);
    }
}
