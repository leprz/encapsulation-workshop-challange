<?php

declare(strict_types=1);

use App\Money\Money;
use App\Printing\BalancePrinter;
use App\Printing\CapitalPrinter;
use App\Printing\ConsoleFormattedMoneyPrinter;
use App\Printing\ConsolePrinter;
use App\Printing\WalletPrinter;
use App\Trading\Customer;
use App\Trading\Exception\NotEnoughFundsErrorException;
use App\Trading\Exception\ProductNotAvailableInStockErrorException;
use App\Trading\Manufacturer;
use App\Trading\Shop;

require __DIR__ . '/vendor/autoload.php';

$output = new ConsolePrinter();
$moneyPrinter = new ConsoleFormattedMoneyPrinter($output);
$capitalPrinter = new CapitalPrinter($output, $moneyPrinter);
$walletPrinter = new WalletPrinter($output, $moneyPrinter);
$balancePrinter = new BalancePrinter($output, $moneyPrinter);

$manufacturer = new Manufacturer();
$shop = new Shop(new Money(0));
$johnDoe = new Customer(new Money(100));

try {
    $shop->resupply(1, $manufacturer, $output);
    $shop->sellProduct(1, $johnDoe);

    $shop->resupply(1, $manufacturer, $output);
    $shop->resupply(2, $manufacturer, $output);
    $shop->resupply(2, $manufacturer, $output);
    $shop->sellProduct(1, $johnDoe);
    $shop->sellProduct(2, $johnDoe);
    $shop->sellProduct(2, $johnDoe);
} catch (NotEnoughFundsErrorException | ProductNotAvailableInStockErrorException $e) {
    $output->writeError($e->getMessage());
    exit(1);
}

$manufacturer->printCapitalOn($capitalPrinter);
$shop->printCapitalOn($capitalPrinter);
$johnDoe->printMoneyLeftOn($walletPrinter);
$shop->printBalanceOn($balancePrinter);
