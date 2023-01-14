<?php

namespace App\Enum;

class QuantidadeParcelasEnum
{
    public const UM = 1;
    public const DUAS = 2;
    public const TRES = 3;
    public const QUATRO = 4;
    public const CINCO = 5;
    public const SEIS = 6;
    public const SETE = 7;
    public const OITO = 8;
    public const NOVE = 9;
    public const DEZ = 10;
    public const ONZE = 11;
    public const DOZE = 12;

    public static function getChoices()
    {
        return [
            '1 Parcela' => self::UM,
            '2 Parcelas' => self::DUAS,
            '3 Parcelas' => self::TRES,
            '4 Parcelas' => self::QUATRO,
            '5 Parcelas' => self::CINCO,
            '6 Parcelas' => self::SEIS,
            '7 Parcelas' => self::SETE,
            '8 Parcelas' => self::OITO,
            '9 Parcelas' => self::NOVE,
            '10 Parcelas' => self::DEZ,
            '11 Parcelas' => self::ONZE,
            '12 Parcelas' => self::DOZE,
        ];
    }
}
