<?php

namespace Moneybatch\Minimalist\Domain;

use Moneybatch\Minimalist\Domain\Conversion\CurrencyConverter;
use Moneybatch\Minimalist\Domain\Currency\Currency;

class Money
{
    private int $value;
    private int $unitCapacity;

    public function __construct(int $subunits, int $unitCapacity = 100)
    {
        $this->value = $subunits;
        $this->unitCapacity = $unitCapacity;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function inSubunits(): int
    {
        return $this->getValue();
    }

    public function inUnits(): float
    {
        $dollars = $this->value / $this->unitCapacity;

        return round((float)$dollars, 2);
    }

    public static function fromUnits(float $units, int $unitCapacity = 100): self
    {
        $subunits = round($units * $unitCapacity);

        return new static($subunits);
    }

    public static function fromSubunits(float $subunits, int $unitCapacity = 100): self
    {
        return new static($subunits, $unitCapacity);
    }

    public function subtract(self $money): self
    {
        return new self($this->value - $money->getValue());
    }

    public function add(self $money): self
    {
        return new self($this->value + $money->getValue());
    }

    public function multiplyBy(int $multiplicator): self
    {
        return new self($this->value * $multiplicator);
    }

    public function divideBy(int $divider): self
    {
        return new self(round($this->value / $divider));
    }

    public function isEmpty(): bool
    {
        return 0 === $this->value;
    }

    public function equal(self $money): bool
    {
        return $this->value === $money->getValue();
    }

    public function greaterThan(self $money): bool
    {
        return $this->value > $money->getValue();
    }

    public function greaterThanOrEquals(self $money): bool
    {
        return $this->value >= $money->getValue();
    }

    public function lessThan(self $money): bool
    {
        return $this->value < $money->getValue();
    }

    public function lessThanOrEquals(self $money): bool
    {
        return $this->value <= $money->getValue();
    }

    public function percent(float $percent): MoneyPercent
    {
        return new MoneyPercent($percent, $this);
    }

}
