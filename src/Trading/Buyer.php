<?php

declare(strict_types=1);

namespace App\Trading;

use App\Money\Money;
use App\Trading\Exception\NotEnoughFundsErrorException;

interface Buyer
{
    /**
     * @throws NotEnoughFundsErrorException
     */
    public function buyProduct(int $sku, Money $price): Money;
}
