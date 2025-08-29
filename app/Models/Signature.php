<?php

namespace App\Models;

use App\Observers\SignatureObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(SignatureObserver::class)]
class Signature extends Model
{
    protected $fillable = [
            'tenant_id',
            'plan_id',
            'gateway_subscription_id',
            'price',
            'recurrence',
            'recurrence_interval',
            'status',
            'started_at',
            'end_at',
            'next_price',
            'price_change_at',
    ];

    public function tenant(): BelongsTo {
        return $this->belongsTo(Tenant::class);
    }

    public function plan(): BelongsTo {
        return $this->belongsTo(Plan::class);
    }

    public function invoices(): HasMany {
        return $this->hasMany(Invoice::class);
    }
}
