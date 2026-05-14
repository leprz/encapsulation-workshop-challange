<?php

declare(strict_types=1);

namespace App\Printing;

use App\Money\FormattedMoneyPrinter;

class ConsoleFormattedMoneyPrinter implements FormattedMoneyPrinter
{
    private const COLUMN_WIDTH = 10;
    private const ANSI_GREEN = "\033[32m";
    private const ANSI_RED = "\033[31m";
    private const ANSI_RESET = "\033[0m";

    private readonly bool $useColor;

    public function __construct(private readonly Printer $output)
    {
        $this->useColor = defined('STDOUT') && stream_isatty(STDOUT);
    }

    public function writeAmount(string $display, bool $negative): void
    {
        $padded = str_pad($display, self::COLUMN_WIDTH, ' ', STR_PAD_LEFT);

        if ($this->useColor) {
            $color = $negative ? self::ANSI_RED : self::ANSI_GREEN;
            $this->output->write($color . $padded . self::ANSI_RESET);
        } else {
            $this->output->write($padded);
        }
    }
}
