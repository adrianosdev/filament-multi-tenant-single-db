<?php

namespace App\Observers;

use App\Enums\InvoiceStatusEnum;
use App\Enums\SignatureStatusEnum;
use App\Models\Signature;
use Carbon\Carbon;

class SignatureObserver
{
    /**
     * Handle the Signature "created" event.
     */
    public function created(Signature $signature): void
    {
        $activeSignature = $signature->tenant->activeSignature;
        if($activeSignature) {
            $activeSignature->update([
                'status' => SignatureStatusEnum::CANCELED->value
            ]);
        }

        $signature->update([
            'status' => SignatureStatusEnum::PENDING->value
        ]);

        $signature->invoices()->create([
            'amount'   => $signature['price'],
            'status'   => InvoiceStatusEnum::PENDING->value,
            'due_date' => Carbon::now()->addDays(1),
        ]);

    }

    /**
     * Handle the Signature "updated" event.
     */
    public function updated(Signature $signature): void
    {
        //
    }

    /**
     * Handle the Signature "deleted" event.
     */
    public function deleted(Signature $signature): void
    {
        //
    }

    /**
     * Handle the Signature "restored" event.
     */
    public function restored(Signature $signature): void
    {
        //
    }

    /**
     * Handle the Signature "force deleted" event.
     */
    public function forceDeleted(Signature $signature): void
    {
        //
    }
}
