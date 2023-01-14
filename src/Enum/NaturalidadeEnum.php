<?php

namespace App\Enum;

class NaturalidadeEnum
{
    public const BRAZIL = 'brasil';
    public const PARAGUAY = 'paraguay';

    public static function getChoices(): array
    {
        return [
            'Brasil' => self::BRAZIL,
            'Paraguai' => self::PARAGUAY,
        ];
    }
}
