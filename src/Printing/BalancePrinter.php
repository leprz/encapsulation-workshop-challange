<?php

declare(strict_types=1);

namespace App\Printing;

use App\Money\FormattedMoney;
use App\Money\FormattedMoneyPrinter;

class BalancePrinter
{
    private const TOTAL_LABEL = 'Total';

    public function __construct(
        private readonly Printer $output,
        private readonly FormattedMoneyPrinter $moneyPrinter
    ) {
    }

    public function start(string $title): void
    {
        $indent = str_repeat(' ', ConsoleLayout::INDENT);
        $this->output->writeLine('');
        $this->output->writeLine($indent . $title);
        $this->output->writeLine($indent . str_repeat(ConsoleLayout::DIVIDER, ConsoleLayout::TOTAL_WIDTH - ConsoleLayout::INDENT));
    }

    public function entry(string $title, FormattedMoney $tx): void
    {
        $this->output->write(ConsoleLayout::dotRowPrefix($title));
        $tx->render($this->moneyPrinter);
        $this->output->writeLine('');
    }

    public function finish(FormattedMoney $total): void
    {
        $indent = str_repeat(' ', ConsoleLayout::INDENT);
        $this->output->writeLine($indent . str_repeat(ConsoleLayout::DIVIDER, ConsoleLayout::TOTAL_WIDTH - ConsoleLayout::INDENT));

        $gap = ConsoleLayout::TOTAL_WIDTH - ConsoleLayout::INDENT - mb_strlen(self::TOTAL_LABEL) - ConsoleLayout::AMOUNT_WIDTH;
        $this->output->write($indent . self::TOTAL_LABEL . str_repeat(' ', $gap));
        $total->render($this->moneyPrinter);
        $this->output->writeLine('');
    }
}
