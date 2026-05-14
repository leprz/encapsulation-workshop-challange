<?php

declare(strict_types=1);

namespace App\Catalog;

use App\Money\Money;
use App\Trading\Buyer;
use App\Trading\Exception\NotEnoughFundsErrorException;

readonly class Product
{
    public function __construct(
        private int   $sku,
        private Money $price
    ) {
    }

    /**
     * @throws NotEnoughFundsErrorException
     */
    public function sellTo(Buyer $buyer): Money
    {
        return $buyer->buyProduct($this->sku, $this->price);
    }

    public function addPriceMargin(float $margin): Product
    {
        return new Product($this->sku, $this->price->multiply(1 + $margin));
    }
}
