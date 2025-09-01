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

class SyncPlanWithMercadoPagoJob implements ShouldQueue
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
        try {

            $accessToken = config('services.mercadopago.token');
            $baseUrl = config('services.mercadopago.base_url');

            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->contentType('application/json')
                ->post($baseUrl . '/preapproval_plan', $this->plan);

            if ($response->successful()) {
                $data = $response->json();

                $this->plan->update([
                    'preapproval_plan_id' => $data['id'] ?? null,
                    'collector_id' => $data['collector_id'] ?? null,
                    'application_id' => $data['application_id'] ?? null,
                    'status' => 'active',
                    'init_point' => $data['init_point'] ?? null,
                ]);
            } else {
                $this->plan->update([
                    'status' => 'inactive',
                ]);
            }
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Erro!')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}
