<?php

namespace App\Filament\Resources\Plans\Tables;

use App\Enums\PlanStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reason')
                    ->label('Nome/Descrição')
                    ->searchable(),
                TextColumn::make('auto_recurring.frequency_type')
                    ->label('Tipo de Frequência'),
                TextColumn::make('auto_recurring.frequency')
                    ->label('Frequência')
                    ->alignEnd(),
                TextColumn::make('auto_recurring.transaction_amount')
                    ->label('Preço')
                    ->money('BRL')
                    ->alignEnd(),
                TextColumn::make('auto_recurring.status')
                    ->label('Status na API')
                    ->badge()
                    ->state(function ($record) {
                        $status = $record->status; // pega api_response['status'] se existir

                        return $status
                            ? PlanStatusEnum::from($status)->label()
                            : 'Desconhecido';
                    })
                    ->color(function ($record) {
                        $status = $record->status;

                        return $status
                            ? PlanStatusEnum::from($status)->color()
                            : 'gray';
                    })
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('api_response.init_point')
                    ->copyable(),
                TextColumn::make('api_response.date_created')
                    ->label('Criado na API')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('api_response.last_modified')
                    ->label('Última Modificação na API')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_sync.message')
                    ->label('Última Sync API')
                    ->badge()
                    ->color(function ($record) {
                        if (isset($record->last_sync['message'])) {
                            return $record->last_sync['message'] === 'success' ? 'success' : 'danger';
                        }
                        return 'secondary';
                    })
                    ->alignCenter(),
                TextColumn::make('back_url')
                    ->label('URL de Retorno')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Criado no Sistema')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Atualizado no Sistema')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->hiddenLabel(),
                EditAction::make()->hiddenLabel(),
                DeleteAction::make()->hiddenLabel(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
