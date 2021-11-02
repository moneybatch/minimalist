<?php

namespace Moneybatch\Minimalist\Domain;

class MoneyPercent
{
    private Money $from;
    private float $percent;

    public function __construct(float $percent, Money $from)
    {
        $this->from = $from;
        $this->percent = $percent;
    }

    public function get(): Money
    {
        $newValue = ($this->percent * $this->from->getValue()) / 100;

        return new Money(round($newValue));
    }

    public function subtract(): Money
    {
        return new Money($this->from->getValue() - $this->get()->getValue());
    }

    public function add(): Money
    {
        return new Money($this->from->getValue() + $this->get()->getValue());
    }

    public function getBase(): Money
    {
        return $this->from;
    }

    public function getPercent(): float
    {
        return $this->percent;
    }
}
