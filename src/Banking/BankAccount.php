<?php

declare(strict_types=1);

namespace App\Banking;

use App\Money\Money;
use App\Printing\BalancePrinter;
use App\Printing\CapitalPrinter;

class BankAccount
{
    private const OVERDRAFT_COMMISSION_RATE = 0.05;

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
        return $expense->multiply(self::OVERDRAFT_COMMISSION_RATE)->negate();
    }

    private function getCapital(): Money
    {
        return array_reduce(
            $this->balance,
            static fn(Money $carry, Money $item): Money => $carry->add($item),
            new Money(0)
        );
    }

    public function printCapitalOn(CapitalPrinter $printer, string $owner): void
    {
        $printer->render($owner, $this->getCapital()->format());
    }

    public function printBalanceOn(BalancePrinter $printer, string $title): void
    {
        $printer->start($title);

        $total = new Money(0);
        foreach ($this->balance as $transaction) {
            $printer->entry($transaction->format());
            $total = $total->add($transaction);
        }

        $printer->finish($total->format());
    }
}
