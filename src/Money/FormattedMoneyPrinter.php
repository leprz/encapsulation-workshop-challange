<?php

declare(strict_types=1);

namespace App\Money;

interface FormattedMoneyPrinter
{
    public function writeAmount(string $display, bool $negative): void;
}
