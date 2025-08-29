<?php

namespace App\Enums;

enum InvoiceStatusEnum: string
{
    case PENDING  = 'pending';
    case PAID     = 'paid';
    case FAILED   = 'failed';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::PENDING  => 'Pendente',
            self::PAID     => 'Pago',
            self::FAILED   => 'Fracassado',
            self::REFUNDED => 'Recusado',
        };
    }
    public static function getOptions(): array
    {
        return [
            self::PENDING->value  => self::PENDING->label(),
            self::PAID->value     => self::PAID->label(),
            self::FAILED->value   => self::FAILED->label(),
            self::REFUNDED->value => self::REFUNDED->label(),
        ];
    }
}
