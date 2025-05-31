<?php

namespace App\Enums;

enum TicketSeverity: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::CRITICAL => 'Critical',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white',
            self::MEDIUM => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-500 text-white',
            self::HIGH => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-500 text-white',
            self::CRITICAL => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white',
        };
    }
}