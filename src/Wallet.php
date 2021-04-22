<?php

declare(strict_types=1);

namespace App;

class Wallet
{
    private Money $cash;

    public function __construct(Money $cash)
    {
        $this->cash = $cash;
    }

    /**
     * @param \App\Money $amount
     * @return \App\Money
     * @throws \App\WalletNotEnoughCashErrorException
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

    public function printAvailableCache(): void
    {
        echo "Cash in the wallet: {$this->cash} \n";
    }
}
