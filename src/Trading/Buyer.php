<?php

declare(strict_types=1);

namespace App\Trading;

use App\Money\Money;
use App\Trading\Exception\NotEnoughFoundsErrorException;

interface Buyer
{
    /**
     * @throws NotEnoughFoundsErrorException
     */
    public function buyProduct(int $sku, Money $price): Money;
}
