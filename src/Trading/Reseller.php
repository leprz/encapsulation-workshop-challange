<?php

declare(strict_types=1);

namespace App\Trading;

use App\Catalog\Product;

interface Reseller extends Buyer
{
    public function receiveStock(int $sku, Product $product): void;
}
