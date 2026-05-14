<?php

declare(strict_types=1);

namespace App\Money;

final readonly class FormattedMoney
{
    public function __construct(
        private string $display,
        private bool $negative
    ) {
    }

    public function render(FormattedMoneyPrinter $printer): void
    {
        $printer->writeAmount($this->display, $this->negative);
    }
}
