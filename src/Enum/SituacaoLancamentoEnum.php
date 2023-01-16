<?php

namespace App\Enum;

class SituacaoLancamentoEnum
{
    public const PENDENTE = 'pendente';
    public const PAGO = 'pago';
    public const CANCELADO = 'cancelado';

    public static function getChoices(): array
    {
        return [
            'Pendente' => self::PENDENTE,
            'Pago' => self::PAGO,
            'Cancelado' => self::CANCELADO,
        ];
    }
}
