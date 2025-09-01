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
                    ->numeric()
                    ->sortable(),
                TextColumn::make('preapproval_plan_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reason')
                    ->searchable(),
                TextColumn::make('external_reference')
                    ->searchable(),
                TextColumn::make('payer_email')
                    ->searchable(),
                TextColumn::make('card_token_id')
                    ->searchable(),
                TextColumn::make('back_url')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
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
