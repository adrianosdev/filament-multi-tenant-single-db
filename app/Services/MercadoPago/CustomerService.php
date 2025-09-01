<?php

namespace App\Services\MercadoPago;
use Illuminate\Support\Facades\Http;

class CustomerService
{
    public function create(array $data)
    {
        $accessToken = config('services.mercadopago.token');
        $baseUrl = config('services.mercadopago.base_url');

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->contentType('application/json')
            ->post($baseUrl . '/v1/customers', ['email' => $data['email']]);

        return $response;
    }
}
