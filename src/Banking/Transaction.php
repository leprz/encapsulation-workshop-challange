<?php

declare(strict_types=1);

namespace App\Banking;

use App\Money\Money;

final class Transaction
{
    public function __construct(
        public readonly string $title,
        public readonly Money $amount
    ) {
    }
}
