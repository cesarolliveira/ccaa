<?php

namespace App\Enum;

class BooleanEnum
{
    public const SIM = 'sim';
    public const NAO = 'nao';

    public static function getChoices(): array
    {
        return [
            'Sim' => self::SIM,
            'Não' => self::NAO,
        ];
    }
}
