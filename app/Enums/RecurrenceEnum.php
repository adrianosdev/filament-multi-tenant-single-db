<?php

namespace App\Enums;

enum RecurrenceEnum: string
{
    case DAILY   = 'daily';
    case MONTHLY = 'monthly';
    case YEARLY  = 'yearly';

    public function label(): string
    {
        return match ($this) {
            self::DAILY   => 'Dia(s)',
            self::MONTHLY => 'Mês(es)',
            self::YEARLY  => 'Ano(s)',
        };
    }
    public static function getOptions(): array
    {
        return [
            self::DAILY->value   => self::DAILY->label(),
            self::MONTHLY->value => self::MONTHLY->label(),
            self::YEARLY->value  => self::YEARLY->label(),
        ];
    }
}
