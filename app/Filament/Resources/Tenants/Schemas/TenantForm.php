<?php

namespace App\Filament\Resources\Tenants\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->columnSpanFull()
                    ->alignCenter()
                    ->hiddenLabel(),
                TextInput::make('name')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    })
                    ->required(),
                TextInput::make('cpf_cnpj')
                    ->required(),
                TextInput::make('phone_whatsapp')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('slug')
                    ->required()
                    ->readOnly(),
            ]);
    }
}
