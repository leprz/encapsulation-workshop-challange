<?php

declare(strict_types=1);

namespace App\Printing;

use App\Money\FormattedMoney;
use App\Money\FormattedMoneyPrinter;

class BalancePrinter
{
    private const TOTAL_WIDTH = 50;
    private const AMOUNT_WIDTH = 10;
    private const INDENT = 2;
    private const DIVIDER = '─';
    private const TOTAL_LABEL = 'Total';

    public function __construct(
        private readonly Printer $output,
        private readonly FormattedMoneyPrinter $moneyPrinter
    ) {
    }

    public function start(string $title): void
    {
        $indent = str_repeat(' ', self::INDENT);
        $this->output->writeLine('');
        $this->output->writeLine($indent . $title);
        $this->output->writeLine($indent . str_repeat(self::DIVIDER, self::TOTAL_WIDTH - self::INDENT));
    }

    public function entry(FormattedMoney $tx): void
    {
        $leftPad = self::TOTAL_WIDTH - self::INDENT - self::AMOUNT_WIDTH;
        $this->output->write(str_repeat(' ', self::INDENT) . str_repeat(' ', $leftPad));
        $tx->render($this->moneyPrinter);
        $this->output->writeLine('');
    }

    public function finish(FormattedMoney $total): void
    {
        $indent = str_repeat(' ', self::INDENT);
        $this->output->writeLine($indent . str_repeat(self::DIVIDER, self::TOTAL_WIDTH - self::INDENT));

        $gap = self::TOTAL_WIDTH - self::INDENT - mb_strlen(self::TOTAL_LABEL) - self::AMOUNT_WIDTH;
        $this->output->write($indent . self::TOTAL_LABEL . str_repeat(' ', $gap));
        $total->render($this->moneyPrinter);
        $this->output->writeLine('');
    }
}
