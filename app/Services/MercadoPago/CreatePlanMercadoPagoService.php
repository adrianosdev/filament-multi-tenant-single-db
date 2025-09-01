<?php

namespace App\Services\MercadoPago;

use App\Models\Plan;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreatePlanMercadoPagoService
{
    public static function create(array $data)
    {
        try {
            $accessToken = config('services.mercadopago.token');
            $baseUrl = config('services.mercadopago.base_url');

            $responseApi = Http::withToken($accessToken)
                ->acceptJson()
                ->contentType('application/json')
                ->post($baseUrl . '/preapproval_plan', $data);

            $plan = Plan::find($data['id']);
            if (!$plan) {
                Notification::make()
                    ->title('Erro!')
                    ->danger()
                    ->body('Plano não encontrado no sistema.')
                    ->send();
                return;
            }

            if ($responseApi->successful()) {
                $apiData = $responseApi->json();
                $getPlanApi = Http::withToken($accessToken)
                    ->acceptJson()
                    ->contentType('application/json')
                    ->get($baseUrl . '/preapproval_plan/' . $apiData['id'])
                    ->json();

                $planUpdateData = [
                    'status' => $getPlanApi['status'],
                    'api_response' => $getPlanApi,
                    'last_sync' => [
                        'date' => now()->toDateTimeString(),
                        'message' => 'success',
                    ],
                ];
                $plan->updateQuietly($planUpdateData);
            } else {
                $plan->updateQuietly([
                    'last_sync' => [
                        'date' => now()->toDateTimeString(),
                        'message' => 'error',
                        'api_response' => $responseApi->json(),
                    ],
                ]);
                Notification::make()
                    ->title('Erro!')
                    ->danger()
                    ->body('Não foi possível criar o plano no Mercado Pago.')
                    ->send();
            }
        } catch (\Throwable $e) {
            Log::error('Erro CreatePlanMercadoPagoService', [
                'exception' => $e,
                'data' => $data,
            ]);
            Notification::make()
                ->title('Erro!')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}
