<?php

namespace App\Enum;

class TipoLancamentoEnum
{
    public const RECEITA = 'receita';
    public const DESPESA = 'despesa';

    public static function getChoices(): array
    {
        return [
            'Receita' => self::RECEITA,
            'Despesa' => self::DESPESA,
        ];
    }
}
