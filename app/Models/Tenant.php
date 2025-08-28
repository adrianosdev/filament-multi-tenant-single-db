<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
