<?php

namespace App\Filament\Resources\Plans\Schemas;

use App\Enums\PlanStatusEnum;
use App\Enums\RecurrenceEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class PlanForm
{

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reason')
                    ->label('Nome/Descrição')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('back_url')
                    ->label('URL de Retorno')
                    ->required()
                    ->columnSpanFull(),
                Fieldset::make('Configuração Recorrência')
                    ->schema([
                        TextInput::make('auto_recurring.frequency')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->label('Frequência'),

                        Select::make('auto_recurring.frequency_type')
                            ->options(RecurrenceEnum::getOptions())
                            ->default('months')
                            ->required()
                            ->label('Tipo de Frequência'),

                        TextInput::make('auto_recurring.transaction_amount')
                            ->numeric()
                            ->label('Valor'),

                        Select::make('auto_recurring.currency_id')
                            ->options([
                                'BRL' => 'Real',
                            ])
                            ->default('BRL')
                            ->required()
                            ->label('Moeda'),
                    ])
                    ->columns(2),
                Select::make('status')
                    ->hiddenOn('create')
                    ->options(PlanStatusEnum::getOptions())
                    ->required(),
            ]);
    }
}
