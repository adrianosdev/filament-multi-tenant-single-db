<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'reason',
        'status',
        'back_url',
        'auto_recurring',
        'payment_methods_allowed',
        'api_response',
        'last_sync',
    ];

    protected function casts(): array
    {
        return [
            'auto_recurring' => 'array',
            'payment_methods_allowed' => 'array',
            'api_response' => 'array',
            'last_sync' => 'array',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Signature::class);
    }
}
