<?php

namespace App\Enum;

class SituacaoLancamentoEnum
{
    public const PENDENTE = 'pendente';
    public const PAGO = 'pago';
    public const CANCELADO = 'cancelado';
    public const VENCIDO = 'vencido';

    public static function getChoices(): array
    {
        return [
            'Pendente' => self::PENDENTE,
            'Pago' => self::PAGO,
            'Cancelado' => self::CANCELADO,
            'Vencido' => self::VENCIDO,
        ];
    }
}
