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
            'preapproval_plan_id',
            'reason',
            'external_reference',
            'payer_email',
            'card_token_id',
            'auto_recurring',
            'back_url',
            'status',
    ];

    public function tenant(): BelongsTo {
        return $this->belongsTo(Tenant::class);
    }

    public function plan(): BelongsTo {
        return $this->belongsTo(Plan::class, 'preapproval_plan_id', 'preapproval_plan_id');
    }

    public function invoices(): HasMany {
        return $this->hasMany(Invoice::class);
    }
}
