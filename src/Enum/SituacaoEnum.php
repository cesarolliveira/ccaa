<?php

namespace App\Enum;

class SituacaoEnum
{
    public const ATIVO = 'ativo';
    public const INATIVO = 'inativo';

    public static function getChoices(): array
    {
        return [
            'Ativo' => self::ATIVO,
            'Inativo' => self::INATIVO,
        ];
    }
}
