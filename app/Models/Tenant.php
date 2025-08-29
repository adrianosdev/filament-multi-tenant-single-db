<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'cpf_cnpj',
        'phone_whatsapp',
        'email',
        'slug',
        'logo'
    ];

    public function activeSignature(): HasOne {
        return $this->hasOne(Signature::class)->where('status', 'active')->orWhere('status', 'pending');
    }

}
