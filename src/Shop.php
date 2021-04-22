<?php

declare(strict_types=1);

namespace App;

class Shop implements ProductConsumerInterface
{
    /**
     * @var array<int, Product[]>
     */
    private array $stock = [];

    private BankAccount $bankAccount;

    public function __construct(Money $capital)
    {
        $this->bankAccount = new BankAccount();
        $this->bankAccount->addIncome($capital);
    }

    /**
     * @throws \App\ProductNotAvailableInStockErrorException
     * @throws \App\NotEnoughFoundsErrorException
     */
    public function sellProduct(int $sku, Customer $customer): void
    {
        $paidPrice = $this->takeProductFromStockBySku($sku)->sellTo($customer);

        $this->bankAccount->addIncome($paidPrice);
    }

    /**
     * @throws \App\ProductNotAvailableInStockErrorException
     */
    private function takeProductFromStockBySku(int $sku): Product
    {
        if (!array_key_exists($sku, $this->stock) || empty($this->stock[$sku])) {
            throw new ProductNotAvailableInStockErrorException('Product is not available now');
        }

        return array_pop($this->stock[$sku]);
    }

    /**
     * @throws \App\NotEnoughFoundsErrorException
     */
    public function resupply(int $sku, Manufacturer $manufacturer): void
    {
        try {
            $manufacturer->sellTo($sku, $this);
        } catch (ManufacturerUnknownProductErrorException) {
            // Do not throw error. Just notify
            echo "Product sku [$sku] can not be resupplied in this manufacturer. \n";
        }
    }

    public function buyProduct(int $sku, Money $price, Product $product): Money
    {
        $this->bankAccount->addExpense($price);

        $this->stock[$sku][] = $product->addPriceMargin(0.2);

        return $price;
    }

    public function printCapital(): void
    {
        echo "Shop capital is: ";
        $this->bankAccount->printCapital();
        echo "\n";
    }

    public function printBalance(): void
    {
        $this->bankAccount->printBalance();
    }
}
