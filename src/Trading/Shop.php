<?php

declare(strict_types=1);

namespace App\Trading;

use App\Banking\BankAccount;
use App\Catalog\Product;
use App\Money\Money;
use App\Printing\Printer;
use App\Trading\Exception\ManufacturerUnknownProductErrorException;
use App\Trading\Exception\NotEnoughFoundsErrorException;
use App\Trading\Exception\ProductNotAvailableInStockErrorException;

class Shop implements Reseller
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
     * @throws ProductNotAvailableInStockErrorException
     * @throws NotEnoughFoundsErrorException
     */
    public function sellProduct(int $sku, Buyer $buyer): void
    {
        $paidPrice = $this->takeProductFromStockBySku($sku)->sellTo($buyer);

        $this->bankAccount->addIncome($paidPrice);
    }

    /**
     * @throws ProductNotAvailableInStockErrorException
     */
    private function takeProductFromStockBySku(int $sku): Product
    {
        if (!array_key_exists($sku, $this->stock) || empty($this->stock[$sku])) {
            throw new ProductNotAvailableInStockErrorException('Product is not available now');
        }

        return array_pop($this->stock[$sku]);
    }

    /**
     * @throws NotEnoughFoundsErrorException
     */
    public function resupply(int $sku, Supplier $supplier, Printer $printer): void
    {
        try {
            $supplier->sellTo($sku, $this);
        } catch (ManufacturerUnknownProductErrorException) {
            $printer->writeLine("Product sku [$sku] can not be resupplied in this manufacturer. ");
        }
    }

    public function buyProduct(int $sku, Money $price): Money
    {
        $this->bankAccount->addExpense($price);

        return $price;
    }

    public function receiveStock(int $sku, Product $product): void
    {
        $this->stock[$sku][] = $product->addPriceMargin(0.2);
    }

    public function printCapital(Printer $printer): void
    {
        $printer->write("Shop capital is: ");
        $this->bankAccount->printCapital($printer);
        $printer->writeLine("");
    }

    public function printBalance(Printer $printer): void
    {
        $this->bankAccount->printBalance($printer);
    }
}
