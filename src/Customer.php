<?php

declare(strict_types=1);

namespace App;

class Customer implements ProductConsumerInterface
{
    private Wallet $wallet;

    private array $boughtProducts = [];

    public function __construct(Money $cash)
    {
        $this->wallet = new Wallet($cash);
    }

    /**
     * @throws \App\WalletNotEnoughCashErrorException
     */
    public function buyProduct(int $sku, Money $price, Product $product): Money
    {
        $paid = $this->wallet->withdrawMoney($price);
        $this->boughtProducts[$sku] = $product;

        return $paid;
    }

    public function printMoneyLeft(): void
    {
        echo "Customer ";
        $this->wallet->printAvailableCash();
    }
}
