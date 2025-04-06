<?php

namespace App\Enums;

enum SeverityLevel: int
{
    case Emergency = 0;
    case Alert = 1;
    case Critical = 2;
    case Error = 3;
    case Warning = 4;
    case Notice = 5;
    case Informational = 6;
    case Debug = 7;

    public static function getDescription(self $severityLevel): string
    {
        return match($severityLevel) {
            self::Emergency => 'System is unusable',
            self::Alert => 'Immediate action required',
            self::Critical => 'Critical conditions',
            self::Error => 'Runtime errors',
            self::Warning => 'Warning conditions',
            self::Notice => 'Important system events',
            self::Informational => 'Informational messages',
            self::Debug => 'Debug-level messages',
            default => 'Unknown severity level'
        };
    }

    public static function asSelectArray(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => self::getDescription($case), self::cases())
        );
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return self::getDescription($this);
    }
}