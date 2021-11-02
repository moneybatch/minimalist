<?php

namespace Moneybatch\Minimalist\Tests\Domain;

use Moneybatch\Minimalist\Domain\Money;
use Moneybatch\Minimalist\Domain\MoneyPercent;
use Moneybatch\Minimalist\Tests\TestCase;

class MoneyPercentTest extends TestCase
{
    /**
     * @covers \Moneybatch\Minimalist\Domain\MoneyPercent::getBase
     * @covers \Moneybatch\Minimalist\Domain\MoneyPercent::getPercent
     */
    public function test_it_gets_percent_components(): void
    {
        $percent = new MoneyPercent(10, new Money(10000));
        $this->assertSame(10000, $percent->getBase()->inSubunits());
        $this->assertSame(10.0, $percent->getPercent());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\MoneyPercent::get
     */
    public function test_it_gets_the_money_percent(): void
    {
        $percent = new MoneyPercent(10, new Money(10000));
        $this->assertSame(1000, $percent->get()->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\MoneyPercent::get
     */
    public function test_it_subtracts_the_money_percent(): void
    {
        $percent = new MoneyPercent(10, new Money(10000));
        $this->assertSame(9000, $percent->subtract()->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\MoneyPercent::get
     */
    public function test_it_adds_the_money_percent(): void
    {
        $percent = new MoneyPercent(10, new Money(10000));
        $this->assertSame(11000, $percent->add()->inSubunits());
    }
}
