<?php

declare(strict_types=1);

namespace App;

interface ProductConsumerInterface
{
    /**
     * @throws \App\NotEnoughFoundsErrorException
     */
    public function buyProduct(int $sku, Money $price, Product $product): Money;
}
