<?php

namespace Modules\Clients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\Employees\Models\Employee;

class Client extends Model {
    use Notifiable;

    protected $fillable = [
        'client_name',
        'sales_agent_id',
    ];

    protected $hidden = [
        'sales_agent_id',
        'created_at',
        'updated_at',
    ];

    public function contacts(): HasMany {
        return $this->hasMany(Contact::class);
    }

    public function salesAgent(): BelongsTo {
        return $this->belongsTo(Employee::class, 'sales_agent_id');
    }
}
