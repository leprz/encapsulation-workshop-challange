<?php

declare(strict_types=1);

namespace App\Banking;

use App\Money\Money;
use App\Printing\Printer;

class BankAccount
{
    /**
     * @var Money[]
     */
    private array $balance = [];

    public function addIncome(Money $amount): void
    {
        $this->balance[] = $amount;
    }

    public function addExpense(Money $expense): void
    {
        $this->balance[] = $expense->negate();

        if ($this->getCapital()->isNegative()) {
            $this->balance[] = $this->calculateCommission($expense);
        }
    }

    private function calculateCommission(Money $expense): Money
    {
        return $expense->multiply(0.05)->negate();
    }

    private function getCapital(): Money
    {
        return array_reduce(
            $this->balance,
            static fn(Money $carry, Money $item): Money => $carry->add($item),
            new Money(0)
        );
    }

    public function printCapital(Printer $printer): void
    {
        $printer->write((string)$this->getCapital());
    }

    public function printBalance(Printer $printer): void
    {
        $total = new Money(0);

        foreach ($this->balance as $transaction) {
            $total = $total->add($transaction);

            if ($transaction->isNegative()) {
                $printer->writeLine("$transaction ");
            } else {
                $printer->writeLine(" $transaction ");
            }
        }
        $printer->writeLine("----------");
        $printer->writeLine("total: $total");
    }
}
