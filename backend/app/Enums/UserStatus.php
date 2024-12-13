<?php

namespace App\Enums;

enum UserStatus: string
{
    case Active     = 'active';
    case Pending    = 'pending';
    case Inactive   = 'inactive';

    public function label(): array|string|null
    {
        return match($this) {
            self::Active        => __('Ativo'),
            self::Pending       => __('Pendente'),
            self::Inactive      => __('Inativo'),
        };
    }
}
