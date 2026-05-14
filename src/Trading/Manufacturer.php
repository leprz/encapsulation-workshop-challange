<?php

declare(strict_types=1);

namespace App\Trading;

use App\Banking\BankAccount;
use App\Catalog\Product;
use App\Money\Money;
use App\Printing\CapitalPrinter;
use App\Trading\Exception\ManufacturerUnknownProductErrorException;
use App\Trading\Exception\NotEnoughFundsErrorException;

class Manufacturer implements Supplier
{
    private const array CATALOG = [
        1 => ['price' => 10, 'cost' => 8],
        2 => ['price' => 20, 'cost' => 15],
        3 => ['price' => 30, 'cost' => 22],
    ];

    /** @var Product[] */
    private array $products = [];
    /** @var Money[] */
    private array $productionCosts = [];
    private BankAccount $bankAccount;

    public function __construct()
    {
        foreach (self::CATALOG as $sku => $entry) {
            $this->products[$sku] = new Product($sku, new Money($entry['price']));
            $this->productionCosts[$sku] = new Money($entry['cost']);
        }

        $this->bankAccount = new BankAccount();
    }

    /**
     * @throws NotEnoughFundsErrorException
     * @throws ManufacturerUnknownProductErrorException
     */
    public function sellTo(int $sku, Reseller $reseller): void
    {
        $product = $this->makeNewProduct($sku);
        $income = $product->sellTo($reseller);
        $reseller->receiveStock($sku, $product);
        $this->bankAccount->addIncome($income, "Sale #$sku");
    }

    /**
     * @throws ManufacturerUnknownProductErrorException
     */
    private function makeNewProduct(int $sku): Product
    {
        if (!array_key_exists($sku, $this->products)) {
            throw new ManufacturerUnknownProductErrorException(
                "Unknown product with sku $sku can not be produced"
            );
        }

        $this->bankAccount->addExpense($this->productionCosts[$sku], "Production #$sku");

        return clone $this->products[$sku];
    }

    public function printCapitalOn(CapitalPrinter $printer): void
    {
        $this->bankAccount->printCapitalOn($printer, 'Manufacturer');
    }
}
