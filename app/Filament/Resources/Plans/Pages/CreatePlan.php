<?php

namespace App\Filament\Resources\Plans\Pages;

use App\Filament\Resources\Plans\PlanResource;
use App\Models\Plan;
use App\Services\MercadoPago\PlanService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePlan extends CreateRecord
{
    protected static string $resource = PlanResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $response = PlanService::create($data);

        if (! $response->successful() || empty($response->json())) {
            Notification::make()
                ->title('Erro na integração')
                ->body('Não foi possível criar o Plano.' . $response->json()['message'])
                ->danger()
                ->send();
            // Cancela o processo
            $this->halt();
        }

        $resonseDataApi = $response->json();

        $data = [
            'reason' => $resonseDataApi['reason'],
            'status' => $resonseDataApi['status'],
            'back_url' => $resonseDataApi['back_url'],
            'auto_recurring' => $resonseDataApi['auto_recurring'],
            'api_response' => $resonseDataApi,
            'last_sync' => ['date' => now(), 'message' => 'success'],
        ];

        return Plan::create($data);
    }
}
