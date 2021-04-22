<?php

declare(strict_types=1);

namespace App;

use LogicException;

class Product
{
    private int $sku;
    private Money $price;

    public function __construct(int $sku, Money $price)
    {
        $this->sku = $sku;
        $this->price = $price;
    }

    /**
     * @throws \App\NotEnoughFoundsErrorException
     */
    public function sellTo(ProductConsumerInterface $customer): Money
    {
        $paidPrice = $customer->buyProduct($this->sku, $this->price, $this);

        if (!$this->price->equals($paidPrice)) {
            throw new LogicException('Fraud detected');
        }

        return $paidPrice;
    }

    public function addPriceMargin(float $margin): Product
    {
        return new Product($this->sku, $this->price->multiply(1 + $margin));
    }
}
