<?php

declare(strict_types=1);

namespace App\Trading;

use App\Trading\Exception\ManufacturerUnknownProductErrorException;
use App\Trading\Exception\NotEnoughFundsErrorException;

interface Supplier
{
    /**
     * @throws NotEnoughFundsErrorException
     * @throws ManufacturerUnknownProductErrorException
     */
    public function sellTo(int $sku, Reseller $reseller): void;
}
