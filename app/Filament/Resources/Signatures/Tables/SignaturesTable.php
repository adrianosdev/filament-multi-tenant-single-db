<?php

namespace App\Filament\Resources\Signatures\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SignaturesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tenant.name')
                    ->sortable(),
                TextColumn::make('plan.name')
                    ->label('Plano')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Preço')
                    ->money('BRL'),
                TextColumn::make('recurrence')
                    ->label('Recorrência'),
                TextColumn::make('recurrence_interval')
                    ->label('Intervalo de Recorrência')
                    ->numeric(),
                TextColumn::make('status'),
                TextColumn::make('started_at')
                    ->label('Começa em')
                    ->date('d/m/Y'),
                TextColumn::make('end_at')
                    ->label('Termina em')
                    ->date('d/m/Y'),
                TextColumn::make('next_price')
                    ->label('Próximo Preço')
                    ->money('BRL'),
                TextColumn::make('price_change_at')
                    ->label('Mudança de Preço em')
                    ->date('d/m/Y'),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
