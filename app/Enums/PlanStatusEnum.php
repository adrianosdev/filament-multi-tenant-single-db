<?php

namespace App\Enums;

enum PlanStatusEnum: string
{
    case ACTIVE   = 'active';
    case INACTIVE  = 'inactive';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE   => 'Ativo',
            self::INACTIVE  => 'Inativo',
            self::CANCELLED => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE   => 'success',
            self::INACTIVE => 'warning',
            self::CANCELLED => 'danger',
        };
    }

    public static function getOptions(): array
    {
        return [
            self::ACTIVE->value  => self::ACTIVE->label(),
            self::INACTIVE->value   => self::INACTIVE->label(),
            self::CANCELLED->value  => self::CANCELLED->label(),
        ];
    }
}
