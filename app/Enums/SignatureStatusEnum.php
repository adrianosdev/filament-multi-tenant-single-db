<?php

namespace App\Enums;

enum SignatureStatusEnum: string
{
    case PENDING  = 'pending';
    case ACTIVE   = 'active';
    case EXPIRED  = 'expired';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING  => 'Pendente',
            self::ACTIVE   => 'Ativa',
            self::EXPIRED  => 'Expirada',
            self::CANCELED => 'Cancelada',
        };
    }
    public static function getOptions(): array
    {
        return [
            self::PENDING->value  => self::PENDING->label(),
            self::ACTIVE->value   => self::ACTIVE->label(),
            self::EXPIRED->value  => self::EXPIRED->label(),
            self::CANCELED->value => self::CANCELED->label(),
        ];
    }
}
