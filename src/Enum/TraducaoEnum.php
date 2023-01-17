<?php

namespace App\Enum;

class TraducaoEnum
{
    public const PT_BR = 'pt_BR';
    public const PY = 'py';

    public static function getChoices(): array
    {
        return [
            'Português' => self::PT_BR,
            'Espanhol' => self::PY,
        ];
    }
}
