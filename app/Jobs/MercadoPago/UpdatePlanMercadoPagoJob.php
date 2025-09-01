<?php

namespace App\Jobs\MercadoPago;

use App\Models\Plan;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UpdatePlanMercadoPagoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Plan $plan) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $accessToken = config('services.mercadopago.token');
        $baseUrl = config('services.mercadopago.base_url');
        $preapprovalPlanId = $this->plan->preapproval_plan_id;
        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->contentType('application/json')
            ->put($baseUrl . '/preapproval_plan/' . $preapprovalPlanId, $this->plan);

        if ($response->successful()) {
            Notification::make()
                ->title('Sucesso!')
                ->success()
                ->body($response->json('message'))
                ->send();
        } else {
            Notification::make()
                ->title('Erro!')
                ->danger()
                ->body($response->json('message'))
                ->send();
        }
    }
}
