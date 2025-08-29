<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('subscription_id')
                    ->required()
                    ->numeric(),
                TextInput::make('gateway_invoice_id'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed', 'refunded' => 'Refunded'])
                    ->required(),
                DatePicker::make('due_date')
                    ->required(),
                DatePicker::make('paid_at'),
            ]);
    }
}
