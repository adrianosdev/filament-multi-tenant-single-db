<?php

namespace App\Services\MercadoPago;

use App\Models\Plan;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdatePlanMercadoPagoService
{
    public static function update(array $data)
    {
        try {
            $accessToken = config('services.mercadopago.token');
            $baseUrl = config('services.mercadopago.base_url');

            if (!isset($data['api_response']['id'])) {
                Notification::make()
                    ->title('Erro!')
                    ->danger()
                    ->body('ID do plano na API não informado.')
                    ->send();
                return;
            }

            $idPlanApi = $data['api_response']['id'];

            // Atualiza o plano no Mercado Pago
            $responseApi = Http::withToken($accessToken)
                ->acceptJson()
                ->contentType('application/json')
                ->put($baseUrl . '/preapproval_plan/' . $idPlanApi, $data);

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
                $updateData = [
                    'status' => $responseApi['status'],
                    'api_response' => $responseApi->json(),
                    'last_sync' => [
                        'date' => now()->toDateTimeString(),
                        'message' => 'success',
                    ],
                ];
                $plan->updateQuietly($updateData);
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
                    ->body('Não foi possível atualizar o plano no Mercado Pago.')
                    ->send();
            }
        } catch (\Throwable $e) {
            Log::error('Erro UpdatePlanMercadoPagoService', [
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
