<?php

namespace App\Enum;

class FormaPagamentoEnum
{
    public const BOLETO = 'boleto';
    public const CARTAO_CREDITO = 'cartao credito';
    public const CARTAO_DEBITO = 'cartao debito';
    public const DINHEIRO = 'dinheiro';
    public const PIX = 'pix';

    public static function getChoices(): array
    {
        return [
            'Boleto' => self::BOLETO,
            'Cartão de Crédito' => self::CARTAO_CREDITO,
            'Cartão de Débito' => self::CARTAO_DEBITO,
            'Dinheiro' => self::DINHEIRO,
            'Pix' => self::PIX,
        ];
    }
}
