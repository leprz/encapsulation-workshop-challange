<?php

declare(strict_types=1);

namespace App\Printing;

use App\Money\FormattedMoney;
use App\Money\FormattedMoneyPrinter;

class CapitalPrinter
{
    private const TOTAL_WIDTH = 50;
    private const AMOUNT_WIDTH = 10;
    private const INDENT = 2;

    public function __construct(
        private readonly Printer $output,
        private readonly FormattedMoneyPrinter $moneyPrinter
    ) {
    }

    public function render(string $owner, FormattedMoney $capital): void
    {
        $label = "{$owner} capital";
        $dotsLen = self::TOTAL_WIDTH - self::INDENT - mb_strlen($label) - 2 - self::AMOUNT_WIDTH;
        if ($dotsLen < 1) {
            $dotsLen = 1;
        }

        $this->output->write(
            str_repeat(' ', self::INDENT)
            . $label
            . ' '
            . str_repeat('.', $dotsLen)
            . ' '
        );
        $capital->render($this->moneyPrinter);
        $this->output->writeLine('');
    }
}
