<?php

declare(strict_types=1);

use App\Customer;
use App\Money;
use App\NotEnoughFoundsErrorException;
use App\ProductNotAvailableInStockErrorException;
use App\Shop;
use App\Manufacturer;

require __DIR__ . '/vendor/autoload.php';

$manufacturer = new Manufacturer();
$shop = new Shop(new Money(0));
$johnDoe = new Customer(new Money(100));

try {
    $shop->resupply(1, $manufacturer);
    $shop->sellProduct(1, $johnDoe);

    $shop->resupply(1, $manufacturer);
    $shop->resupply(2, $manufacturer);
    $shop->resupply(2, $manufacturer);
    $shop->sellProduct(1, $johnDoe);
    $shop->sellProduct(2, $johnDoe);
    $shop->sellProduct(2, $johnDoe);
} catch (NotEnoughFoundsErrorException | ProductNotAvailableInStockErrorException $e) {
    fwrite(STDERR, "Error: {$e->getMessage()}");
    exit(1);
}

echo "Final ";
$manufacturer->printCapital();

echo "Final ";
$shop->printCapital();

$johnDoe->printMoneyLeft();

echo "\nShop balance: \n";
$shop->printBalance();
