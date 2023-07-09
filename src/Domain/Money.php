<?php

namespace Moneybatch\Minimalist\Domain;

use Moneybatch\Minimalist\Domain\Conversion\CurrencyConverter;
use Moneybatch\Minimalist\Domain\Currency\Currency;

class Money
{
    private float $value;
    private int $unitCapacity;

    public function __construct(float $subunits, int $unitCapacity = 100)
    {
        $this->value = $subunits;
        $this->unitCapacity = $unitCapacity;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function inSubunits(): int
    {
        return round($this->getValue());
    }

    public function inUnits(int $precision = 2): float
    {
        $dollars = $this->value / $this->unitCapacity;

        return round((float)$dollars, $precision);
    }

    public static function fromUnits(float $units, int $unitCapacity = 100): self
    {
        $subunits = $units * $unitCapacity;

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
        return new self($this->value / $divider);
    }

    public function isEmpty(): bool
    {
        return 0.0 === $this->value;
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

    public function isNegative(): bool
    {
        return $this->value < 0;
    }

    public function isPositive(): bool
    {
        return $this->value > 0;
    }

    public function truncateNegative(): self
    {
        if (! $this->isNegative()) {
            return $this;
        }

        return new static(0);
    }

    public static function sum(...$components): self
    {
        $sum = new static(0);

        foreach ($components as $component) {
            $sum = $sum->add($component);
        }

        return $sum;
    }

}
