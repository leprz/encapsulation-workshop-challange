<?php

declare(strict_types=1);

namespace App\Printing;

final class ConsoleLayout
{
    public const int TOTAL_WIDTH = 50;
    public const int AMOUNT_WIDTH = 10;
    public const int INDENT = 2;
    public const string DIVIDER = '─';
    public const string SECTION_DIVIDER = '═';

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