<?php

namespace Modules\Employees\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Clients\Models\Client;
use Modules\Employees\Models\Department;

trait HasEmployeeRelations {
    public function user(): MorphOne {
        return $this->morphOne(User::class, 'userable');
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function assignedClients(): HasMany {
        return $this->hasMany(Client::class, 'sales_agent_id', 'id');
    }
}
