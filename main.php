<?php

declare(strict_types=1);

use App\Money\Money;
use App\Printing\ConsolePrinter;
use App\Trading\Customer;
use App\Trading\Exception\NotEnoughFoundsErrorException;
use App\Trading\Exception\ProductNotAvailableInStockErrorException;
use App\Trading\Manufacturer;
use App\Trading\Shop;

require __DIR__ . '/vendor/autoload.php';

$printer = new ConsolePrinter();

$manufacturer = new Manufacturer();
$shop = new Shop(new Money(0));
$johnDoe = new Customer(new Money(100));

try {
    $shop->resupply(1, $manufacturer, $printer);
    $shop->sellProduct(1, $johnDoe);

    $shop->resupply(1, $manufacturer, $printer);
    $shop->resupply(2, $manufacturer, $printer);
    $shop->resupply(2, $manufacturer, $printer);
    $shop->sellProduct(1, $johnDoe);
    $shop->sellProduct(2, $johnDoe);
    $shop->sellProduct(2, $johnDoe);
} catch (NotEnoughFoundsErrorException | ProductNotAvailableInStockErrorException $e) {
    fwrite(STDERR, "Error: {$e->getMessage()}");
    exit(1);
}

$printer->write("Final ");
$manufacturer->printCapital($printer);

$printer->write("Final ");
$shop->printCapital($printer);

$johnDoe->printMoneyLeft($printer);

$printer->writeLine("");
$printer->writeLine("Shop balance: ");
$shop->printBalance($printer);
