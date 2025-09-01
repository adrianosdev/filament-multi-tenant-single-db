<?php

namespace App\Services\MercadoPago;

use App\Models\Plan;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PlanService
{
    public static function create(array $data)
    {
        $accessToken = config('services.mercadopago.token');
        $baseUrl = config('services.mercadopago.base_url');

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->contentType('application/json')
            ->post($baseUrl . '/preapproval_plan', $data);

        return $response;
    }
}
