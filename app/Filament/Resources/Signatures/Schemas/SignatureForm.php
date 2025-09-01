<?php

namespace App\Filament\Resources\Signatures\Schemas;

use App\Models\Plan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use function Laravel\Prompts\text;

class SignatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(5)
            ->components([
                    Flex::make([
                        Section::make([
                            Select::make('preapproval_plan_id')
                                 ->relationship('plan', 'reason')
                                 ->label('Plano')
                                 ->placeholder('Selecione um plano'),
                        ]),
                        Section::make([
                            TextInput::make('card_number')
                            ->label('Número do Cartão')
                            ->suffixIcon('heroicon-s-credit-card')
                            ->columnSpan(2),
                            TextInput::make('cardholder_name')
                            ->label('Nome do Titular')
                            ->columnSpan(2),
                            TextInput::make('expiration_date')
                            ->label('Vencimento')
                            ->placeholder('MM/AA'),
                            TextInput::make('security_code')
                            ->label('Código de Segurança')
                            ->placeholder('Ex.: 123'),
                            TextInput::make('cardholder_document')
                            ->label('Documento do Titular')
                            ->prefix('CPF/CNPJ')
                            ->columnSpan(2),
                        ])->columns(2),
                    ])->columnSpan(5)
            ]);
    }
}
