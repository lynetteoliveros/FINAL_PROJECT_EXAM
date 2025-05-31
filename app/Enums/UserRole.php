<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case SUPERVISOR = 'supervisor';
    case OFFICER = 'officer';
    case JUNIOR_OFFICER = 'junior_officer';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::SUPERVISOR => 'Supervisor',
            self::OFFICER => 'Officer',
            self::JUNIOR_OFFICER => 'Junior Officer',
        };
    }
}