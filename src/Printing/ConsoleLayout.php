<?php

declare(strict_types=1);

namespace App\Printing;

final class ConsoleLayout
{
    public const TOTAL_WIDTH = 50;
    public const AMOUNT_WIDTH = 10;
    public const INDENT = 2;
    public const DIVIDER = '─';
    public const SECTION_DIVIDER = '═';

    public static function dotRowPrefix(string $label): string
    {
        $dotsLen = self::TOTAL_WIDTH - self::INDENT - mb_strlen($label) - 2 - self::AMOUNT_WIDTH;

        return str_repeat(' ', self::INDENT)
            . $label
            . ' '
            . str_repeat('.', max(1, $dotsLen))
            . ' ';
    }
}