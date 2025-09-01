<?php

namespace App\Services\MercadoPago;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use MercadoPago\Client\CardToken\CardTokenClient;
use MercadoPago\Resources\CardToken;

class CardService
{

    public function prepareData($data) {
        return $data;
    }

    public function generateCardToken($data) {
       $accessToken = config('services.mercadopago.token');
       $baseUrl = config('services.mercadopago.base_url');

        $data = [
            'expiration_month' => substr($data['expiration_date'], 0, 2),
            'expiration_year' => substr(date('Y'), 0, 2) . substr($data['expiration_date'], 3, 2),
            'card_number' => preg_replace('/\D/', '', $data['card_number']),
            'security_code' => $data['security_code'],
            'cardholder'     => [
                'name' => $data['cardholder_name'],
                'identification' => [
                    'number' => preg_replace('/\D/', '', $data['cardholder_document']),
                    'type'   => "CPF"
                ]
            ],
        ];
       $response = Http::withToken($accessToken)
           ->acceptJson()
           ->contentType('application/json')
           ->post($baseUrl . '/v1/card_tokens', $data);

        return $response;
    }

    public function save(array $data)
    {
       $data = $this->generateCardToken($data);
       $external_customer_id = Auth::user()->tenant['external_customer_id'];
       $response = Http::withToken(config('services.mercadopago.token'))
           ->acceptJson()
           ->contentType('application/json')
           ->post(config('services.mercadopago.base_url') . '/v1/customers/'. $external_customer_id .'/cards', ['token' => $data->json()['id']]);

       return dd($response->json());

    }
}
