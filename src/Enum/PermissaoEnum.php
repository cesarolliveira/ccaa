<?php

namespace App\Enum;

class PermissaoEnum
{
    public const ADMIN = 'ROLE_ADMIN';
    public const GERENTE = 'ROLE_GERENTE';
    public const USUARIO = 'ROLE_USUARIO';

    public static function getChoices(): array
    {
        return [
            'Administrador' => self::ADMIN,
            'Gerente' => self::GERENTE,
            'Usuário' => self::USUARIO,
        ];
    }
}
