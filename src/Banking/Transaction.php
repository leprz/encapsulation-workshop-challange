<?php

declare(strict_types=1);

namespace App\Banking;

use App\Money\Money;

final readonly class Transaction
{
    public function __construct(
        public string $title,
        public Money  $amount
    ) {
    }
}
