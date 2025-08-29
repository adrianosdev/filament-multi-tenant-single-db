<?php

namespace App\Filament\Resources\Plans\Schemas;

use App\Enums\RecurrenceEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('current_price')
                    ->label('Preço Atual')
                    ->required()
                    ->numeric(),
                Select::make('recurrence')
                    ->label('Recorrência')
                    ->options(RecurrenceEnum::getOptions())
                    ->required(),
                TextInput::make('recurrence_interval')
                    ->label('Intervalo de Recorrência')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
