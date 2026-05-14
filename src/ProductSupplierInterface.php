<?php

declare(strict_types=1);

namespace App;

interface ProductSupplierInterface
{
    /**
     * @throws \App\NotEnoughFundsErrorException
     * @throws \App\ManufacturerUnknownProductErrorException
     */
    public function sellTo(int $sku, ProductConsumerInterface $consumer): void;
}
