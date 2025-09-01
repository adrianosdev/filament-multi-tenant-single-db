<?php

namespace App\Filament\Resources\Tenants\Pages;

use App\Filament\Resources\Tenants\TenantResource;
use App\Models\Tenant;
use App\Services\MercadoPago\CustomerService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $response =  (new CustomerService())->create($data);

        if (! $response->successful() || empty($response->json())) {
            Notification::make()
                ->title('Erro na integração')
                ->body($response->json()['message'])
                ->danger()
                ->send();
            // Cancela o processo
            $this->halt();
        }

        $data['external_customer_id'] = $response['id'];

        return Tenant::create($data);
    }
}
