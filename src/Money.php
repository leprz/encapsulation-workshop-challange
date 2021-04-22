<?php

declare(strict_types=1);

namespace App;

class Money
{
    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function subtract(Money $amount): self
    {
        return new self($this->amount - $amount->amount);
    }

    public function add(Money $amount): self
    {
        return new self($this->amount + $amount->amount);
    }

    public function negate(): self
    {
        return (new self(0))->subtract($this);
    }

    public function multiply(float $multiplier): self
    {
        return new self(round($this->amount * $multiplier, 2));
    }

    public function isNegative(): bool
    {
        return $this->amount < 0;
    }

    public function equals(self $money): bool
    {
        return $this->amount === $money->amount;
    }

    public function __toString(): string
    {
        if ($this->isNegative()) {
            return '-$' . $this->amount * -1;
        }

        return '$' . $this->amount;
    }
}
