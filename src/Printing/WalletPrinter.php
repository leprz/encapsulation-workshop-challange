<?php

declare(strict_types=1);

namespace App\Printing;

use App\Money\FormattedMoney;
use App\Money\FormattedMoneyPrinter;

readonly class WalletPrinter
{
    public function __construct(
        private Printer               $output,
        private FormattedMoneyPrinter $moneyPrinter
    ) {
    }

    public function render(string $owner, FormattedMoney $cash): void
    {
        $this->output->write(ConsoleLayout::dotRowPrefix("$owner wallet"));
        $cash->render($this->moneyPrinter);
        $this->output->writeLine('');
    }
}
