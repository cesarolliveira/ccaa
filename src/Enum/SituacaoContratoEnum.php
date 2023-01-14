<?php

namespace App\Enum;

class SituacaoContratoEnum
{
    public const ATIVO = 'ativo';
    public const INATIVO = 'inativo';
    public const CANCELADO = 'cancelado';

    public static function getChoices()
    {
        return [
            'Ativo' => self::ATIVO,
            'Inativo' => self::INATIVO,
            'Cancelado' => self::CANCELADO,
        ];
    }
}
