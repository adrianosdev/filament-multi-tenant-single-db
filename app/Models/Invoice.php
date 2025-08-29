<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'signature_id',
        'gateway_invoice_id',
        'amount',
        'status',
        'due_date',
        'paid_at',
    ];

    public function signature(): BelongsTo {
        return $this->belongsTo(Signature::class);
    }
}
