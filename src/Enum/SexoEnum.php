<?php

namespace App\Enum;

class SexoEnum
{
    public const MASCULINO = 'masculino';
    public const FEMININO = 'feminino';

    public static function getChoices(): array
    {
        return [
            'Masculino' => self::MASCULINO,
            'Feminino' => self::FEMININO,
        ];
    }
}
