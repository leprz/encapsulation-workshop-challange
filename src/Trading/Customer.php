<?php

declare(strict_types=1);

namespace App\Trading;

use App\Banking\Wallet;
use App\Money\Money;
use App\Printing\Printer;
use App\Trading\Exception\WalletNotEnoughCashErrorException;

class Customer implements Buyer
{
    private Wallet $wallet;

    public function __construct(Money $cash)
    {
        $this->wallet = new Wallet($cash);
    }

    /**
     * @throws WalletNotEnoughCashErrorException
     */
    public function buyProduct(int $sku, Money $price): Money
    {
        return $this->wallet->withdrawMoney($price);
    }

    public function printMoneyLeft(Printer $printer): void
    {
        $printer->write("Customer ");
        $this->wallet->printAvailableCache($printer);
    }
}
