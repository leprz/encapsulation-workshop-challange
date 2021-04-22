<?php

declare(strict_types=1);

namespace App;

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

    public function printCapital(): void
    {
        echo $this->getCapital();
    }

    public function printBalance(): void
    {
        $total = new Money(0);

        foreach ($this->balance as $transaction) {
            $total = $total->add($transaction);

            if ($transaction->isNegative()) {
                echo "$transaction \n";
            } else {
                echo " $transaction \n";
            }
        }
        echo "----------\n";
        echo "total: $total\n";
    }
}
