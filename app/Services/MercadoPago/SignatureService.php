<?php

namespace App\Services\MercadoPago;

use App\Models\Plan;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SignatureService
{

    public function prepareData($data) {

        $tenant = Tenant::find($data['tenant_id']);
        $plan = Plan::where('preapproval_plan_id', $data['preapproval_plan_id'])->first();
        $end_date = ($plan['auto_recurring']['frequency_type'] == 'months')
                        ? Carbon::now()->addMonths($plan['auto_recurring']['frequency'])
                        : Carbon::now()->addDays($plan['auto_recurring']['frequency']);
        $auto_recurring = [
            'frequency' => $plan['auto_recurring']['frequency'],
            'frequency_type' => $plan['auto_recurring']['frequency_type'],
            'start_date' => Carbon::now()->format('Y-m-d'),
            'end_date'  => $end_date->format('Y-m-d'),
            'transaction_amount' => $plan['auto_recurring']['transaction_amount'],
            'currency_id' => $plan['auto_recurring']['currency_id']
        ];
        $data = [
            'preapproval_plan_id' => $data['preapproval_plan_id'],
            'reason'              => $plan['reason'],
            'payer_email'         => $tenant['email'],
            'card_token_id'       => $tenant['card_token_id'],
            'auto_recurring'      =>  $auto_recurring,
            'back_url'            => $plan['back_url'],
            'status'              => 'pending'
        ];
        return $data;
    }

    public function create(array $data)
    {
        $data = $this->prepareData($data);

        $accessToken = config('services.mercadopago.token');
        $baseUrl = config('services.mercadopago.base_url');

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->contentType('application/json')
            ->post($baseUrl . '/preapproval', $data);

        return dd($response->json());
    }
}
