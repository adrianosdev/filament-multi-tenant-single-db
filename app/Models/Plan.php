<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'gateway_plan_id',
        'name',
        'recurrence',
        'recurrence_interval',
        'trial_period_days',
        'current_price',
    ];

    public function subscriptions(): HasMany {
        return $this->hasMany(Signature::class);
    }
}
