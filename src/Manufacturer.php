<?php

declare(strict_types=1);

namespace App;

use LogicException;

class Manufacturer
{
    /** @var Product[] */
    private array $products;
    private BankAccount $bankAccount;

    public function __construct()
    {
        $this->products[1] = new Product(1, new Money(10));
        $this->products[2] = new Product(2, new Money(20));
        $this->products[3] = new Product(3, new Money(30));

        $this->bankAccount = new BankAccount();
    }

    private function getCostOfProductionBySku(int $sku): Money
    {
        return match ($sku) {
            1 => new Money(8),
            2 => new Money(15),
            3 => new Money(22),
            default => throw new LogicException('Product do not exist')
        };
    }

    /**
     * @throws \App\NotEnoughFoundsErrorException
     * @throws \App\ManufacturerUnknownProductErrorException
     */
    public function sellTo(int $sku, Shop $shop): void
    {
        $income = $this->makeNewProduct($sku)->sellTo($shop);
        $this->bankAccount->addIncome($income);
    }

    /**
     * @throws \App\ManufacturerUnknownProductErrorException
     */
    private function makeNewProduct(int $sku): Product
    {
        if (!array_key_exists($sku, $this->products)) {
            throw new ManufacturerUnknownProductErrorException(
                "Unknown product with sku $sku can not be produced"
            );
        }

        $this->bankAccount->addExpense($this->getCostOfProductionBySku($sku));

        return clone $this->products[$sku];
    }

    public function printCapital(): void
    {
        echo "Manufacturer capital is: ";
        $this->bankAccount->printCapital();
        echo "\n";
    }
}
