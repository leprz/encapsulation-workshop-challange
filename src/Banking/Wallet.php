<?php

declare(strict_types=1);

namespace App\Banking;

use App\Money\Money;
use App\Printing\Printer;
use App\Trading\Exception\WalletNotEnoughCashErrorException;

class Wallet
{
    private Money $cash;

    public function __construct(Money $cash)
    {
        $this->cash = $cash;
    }

    /**
     * @throws WalletNotEnoughCashErrorException
     */
    public function withdrawMoney(Money $amount): Money
    {
        $moneyAfterPayment = $this->cash->subtract($amount);

        if ($moneyAfterPayment->isNegative()) {
            throw new WalletNotEnoughCashErrorException('Not enough money');
        }

        $this->cash = $moneyAfterPayment;

        return $amount;
    }

    public function printAvailableCache(Printer $printer): void
    {
        $printer->writeLine("Cash in the wallet: {$this->cash} ");
    }
}
