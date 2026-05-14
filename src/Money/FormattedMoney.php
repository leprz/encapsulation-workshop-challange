<?php

declare(strict_types=1);

namespace App\Money;

final class FormattedMoney
{
    public function __construct(
        private readonly string $display,
        private readonly bool $negative
    ) {
    }

    public function render(FormattedMoneyPrinter $printer): void
    {
        $printer->writeAmount($this->display, $this->negative);
    }
}
