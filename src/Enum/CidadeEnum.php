<?php

namespace App\Enum;

class CidadeEnum
{
    public const GUAIRA = 'guaira';
    public const SALTO_DEL_GUAIRA = 'salto del guaira';

    public static function getChoices(): array
    {
        return [
            'Guaíra' => self::GUAIRA,
            'Salto del Guairá' => self::SALTO_DEL_GUAIRA,
        ];
    }
}
