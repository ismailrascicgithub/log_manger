<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::EDITOR => 'Editor',
        };
    }
}