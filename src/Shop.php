<?php

declare(strict_types=1);

namespace App;

class Shop implements ProductConsumerInterface
{
    private const RESALE_MARGIN = 0.2;

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
     * @throws \App\NotEnoughFundsErrorException
     */
    public function sellProduct(int $sku, ProductConsumerInterface $consumer): void
    {
        $paidPrice = $this->takeProductFromStockBySku($sku)->sellTo($consumer);

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
     * @throws \App\NotEnoughFundsErrorException
     */
    public function resupply(int $sku, ProductSupplierInterface $supplier): void
    {
        try {
            $supplier->sellTo($sku, $this);
        } catch (ManufacturerUnknownProductErrorException) {
            // Unknown product in the supplier's catalog is not fatal for the shop.
        }
    }

    public function buyProduct(int $sku, Money $price, Product $product): Money
    {
        $this->bankAccount->addExpense($price);

        $this->stock[$sku][] = $product->addPriceMargin(self::RESALE_MARGIN);

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
