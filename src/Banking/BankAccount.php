<?php

declare(strict_types=1);

namespace App\Banking;

use App\Money\Money;
use App\Printing\BalancePrinter;
use App\Printing\CapitalPrinter;

class BankAccount
{
    private const float OVERDRAFT_COMMISSION_RATE = 0.05;

    /** @var Transaction[] */
    private array $balance = [];

    public function addIncome(Money $amount, string $title): void
    {
        $this->balance[] = new Transaction($title, $amount);
    }

    public function addExpense(Money $expense, string $title): void
    {
        $this->balance[] = new Transaction($title, $expense->negate());

        if ($this->getCapital()->isNegative()) {
            $this->balance[] = new Transaction('Overdraft commission', $this->calculateCommission($expense));
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
            static fn(Money $carry, Transaction $tx): Money => $carry->add($tx->amount),
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
        foreach ($this->balance as $tx) {
            $printer->entry($tx->title, $tx->amount->format());
            $total = $total->add($tx->amount);
        }

        $printer->finish($total->format());
    }
}
