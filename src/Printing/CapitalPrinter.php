<?php

declare(strict_types=1);

namespace App\Printing;

use App\Money\FormattedMoney;
use App\Money\FormattedMoneyPrinter;

class CapitalPrinter
{
    public function __construct(
        private readonly Printer $output,
        private readonly FormattedMoneyPrinter $moneyPrinter
    ) {
    }

    public function render(string $owner, FormattedMoney $capital): void
    {
        $this->output->write(ConsoleLayout::dotRowPrefix("{$owner} capital"));
        $capital->render($this->moneyPrinter);
        $this->output->writeLine('');
    }
}
