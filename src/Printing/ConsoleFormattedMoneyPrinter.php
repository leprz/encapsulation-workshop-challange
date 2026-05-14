<?php

declare(strict_types=1);

namespace App\Printing;

use App\Money\FormattedMoneyPrinter;

class ConsoleFormattedMoneyPrinter implements FormattedMoneyPrinter
{
    private readonly bool $useColor;

    public function __construct(private readonly Printer $output)
    {
        $this->useColor = defined('STDOUT') && stream_isatty(STDOUT);
    }

    public function writeAmount(string $display, bool $negative): void
    {
        $padded = str_pad($display, ConsoleLayout::AMOUNT_WIDTH, ' ', STR_PAD_LEFT);

        if ($this->useColor) {
            $color = $negative ? AnsiColor::RED : AnsiColor::GREEN;
            $this->output->write($color . $padded . AnsiColor::RESET);
        } else {
            $this->output->write($padded);
        }
    }
}
