<?php

namespace App\Filament\Resources\Signatures\Schemas;

use App\Enums\RecurrenceEnum;
use App\Enums\SignatureStatusEnum;
use App\Models\Plan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SignatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Cliente')->schema([
                    Select::make('tenant_id')
                        ->relationship('tenant', 'name')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                Fieldset::make('Plano')->schema([
                    Select::make('plan_id')
                        ->label('Plano')
                        ->relationship('plan', 'name')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn(Set $set, $state, Get $get) => [
                            $plan = $state ? Plan::find($state) : null,
                            $set('price', $plan?->current_price ?? 0.00),
                            $set('recurrence', $plan?->recurrence),
                            $set('recurrence_interval', $plan?->recurrence_interval),
                        ]),
                    TextInput::make('price')
                        ->label('Preço')
                        ->required()
                        ->numeric()
                        ->prefix('$')
                        ->default(0.00),
                    TextInput::make('status')
                        ->disabled()
                        ->hiddenOn('create')
                        ->columnSpanFull(),
                    TextInput::make('next_price')
                        ->label('Novo Preço')
                        ->numeric()
                        ->hiddenOn('create'),
                    DatePicker::make('price_change_at')
                        ->label('Mudança de Preço em')
                        ->hiddenOn('create'),
                ]),
                Fieldset::make('Cobrança')
                ->schema([
                    Select::make('recurrence')
                        ->label('Recorrência')
                        ->options(RecurrenceEnum::getOptions())
                        ->required(),
                    TextInput::make('recurrence_interval')
                        ->label('Intervalo de Recorrência')
                        ->required()
                        ->numeric(),
                    DatePicker::make('started_at')
                        ->label('Começa em')
                        ->disabled()
                        ->hiddenOn('create'),
                    DatePicker::make('started_at')
                        ->label('Termina em')
                        ->disabled()
                        ->hiddenOn('create'),
                ]),
            ]);
    }
}
