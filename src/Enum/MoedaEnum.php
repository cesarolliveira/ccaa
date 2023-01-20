<?php

namespace App\Enum;

class MoedaEnum
{
    public const BRL = 'BRL';
    public const PYG = 'PYG';

    public static function getChoices(): array
    {
        return [
            'BRL' => self::BRL,
            'PYG' => self::PYG,
        ];
    }
}
