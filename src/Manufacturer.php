<?php

declare(strict_types=1);

namespace App;

class Manufacturer implements ProductSupplierInterface
{
    private const CATALOG = [
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
     * @throws \App\NotEnoughFundsErrorException
     * @throws \App\ManufacturerUnknownProductErrorException
     */
    public function sellTo(int $sku, ProductConsumerInterface $consumer): void
    {
        $income = $this->makeNewProduct($sku)->sellTo($consumer);
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

        $this->bankAccount->addExpense($this->productionCosts[$sku]);

        return clone $this->products[$sku];
    }

    public function printCapital(): void
    {
        echo "Manufacturer capital is: ";
        $this->bankAccount->printCapital();
        echo "\n";
    }
}
