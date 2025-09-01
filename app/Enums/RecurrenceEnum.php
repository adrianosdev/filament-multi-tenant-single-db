<?php

namespace App\Enums;

enum RecurrenceEnum: string
{
    case DAILY   = 'days';
    case MONTHLY = 'months';

    public function label(): string
    {
        return match ($this) {
            self::DAILY   => 'Dia(s)',
            self::MONTHLY => 'Mês(es)',
        };
    }
    public static function getOptions(): array
    {
        return [
            self::DAILY->value   => self::DAILY->label(),
            self::MONTHLY->value => self::MONTHLY->label(),
        ];
    }
}
