<?php

namespace App\Enum;

class VencimentoContratoEnum
{
    public const VENCIMENTO_5 = 5;
    public const VENCIMENTO_10 = 10;
    public const VENCIMENTO_15 = 15;
    public const VENCIMENTO_20 = 20;
    public const VENCIMENTO_25 = 25;

    public static function getChoices(): array
    {
        return [
            '5' => self::VENCIMENTO_5,
            '10' => self::VENCIMENTO_10,
            '15' => self::VENCIMENTO_15,
            '20' => self::VENCIMENTO_20,
            '25' => self::VENCIMENTO_25,
        ];
    }
}
