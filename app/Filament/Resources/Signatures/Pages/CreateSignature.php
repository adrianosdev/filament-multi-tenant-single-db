<?php

namespace App\Filament\Resources\Signatures\Pages;

use App\Filament\Resources\Signatures\SignatureResource;
use App\Models\Signature;
use App\Services\MercadoPago\CardService;
use App\Services\MercadoPago\SignatureService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateSignature extends CreateRecord
{
    protected static string $resource = SignatureResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        (new CardService()->save($data));
        (new SignatureService())->create($data);
        return Signature::create($data);
    }
}
