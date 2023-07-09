<?php

namespace Moneybatch\Minimalist\Tests\Domain;

use Moneybatch\Minimalist\Domain\Money;
use Moneybatch\Minimalist\Domain\MoneyPercent;
use Moneybatch\Minimalist\Tests\TestCase;

class MoneyTest extends TestCase
{

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::fromUnits
     */
    public function test_it_makes_money_from_units(): void
    {
        $dollars = 10.99;
        $money = Money::fromUnits($dollars);

        $this->assertSame(1099.0, $money->getValue());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::fromSubunits
     */
    public function test_it_makes_money_from_subunits(): void
    {
        $cents = 1099;
        $money = Money::fromSubunits($cents);

        $this->assertSame(1099.0, $money->getValue());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::__construct
     */
    public function test_it_makes_money_from_cents_regularly(): void
    {
        $money = new Money(1200);
        $this->assertSame(1200.0, $money->getValue());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::inSubunits
     */
    public function test_it_gets_money_in_subunits(): void
    {
        $money = new Money(1200);
        $this->assertSame(1200, $money->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::inUnits
     */
    public function test_it_gets_money_in_units(): void
    {
        $money = new Money(1099);
        $this->assertSame(10.99, $money->inUnits());

        $money = new Money(1099);
        $this->assertSame(11.0, $money->inUnits(1));

        $money = new Money(1091);
        $this->assertSame(10.9, $money->inUnits(1));

        $money = new Money(1091.1);
        $this->assertSame(10.911, $money->inUnits(3));
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::subtract
     */
    public function test_it_subtracts_money(): void
    {
        $money = new Money(1199);
        $anotherMoney = new Money(1098);
        $difference = $money->subtract($anotherMoney);

        $this->assertEquals(1.01, $difference->inUnits());
        $this->assertEquals(101, $difference->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::add
     */
    public function test_it_adds_money(): void
    {
        $money = new Money(1000);
        $anotherMoney = new Money(2000);
        $difference = $money->add($anotherMoney);

        $this->assertEquals(30, $difference->inUnits());
        $this->assertEquals(3000, $difference->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::isEmpty
     */
    public function test_money_value_is_empty(): void
    {
        $money = new Money(0);
        $this->assertTrue($money->isEmpty());
        $money = new Money(100);
        $this->assertFalse($money->isEmpty());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::equal
     */
    public function test_money_are_equal(): void
    {
        $this->assertTrue((new Money(100))->equal(new Money(100)));
        $this->assertFalse((new Money(101))->equal(new Money(100)));
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::greaterThan
     */
    public function test_money_are_greater_than_other_money(): void
    {
        $this->assertTrue((new Money(101))->greaterThan(new Money(100)));
        $this->assertFalse((new Money(100))->greaterThan(new Money(100)));
        $this->assertFalse((new Money(99))->greaterThan(new Money(100)));
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::greaterThanOrEquals
     */
    public function test_money_are_greater_than_other_money_or_equal(): void
    {
        $this->assertTrue((new Money(101))->greaterThanOrEquals(new Money(100)));
        $this->assertTrue((new Money(100))->greaterThanOrEquals(new Money(100)));
        $this->assertFalse((new Money(99))->greaterThanOrEquals(new Money(100)));
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::greaterThanOrEquals
     */
    public function test_money_are_less_than_other_money(): void
    {
        $this->assertTrue((new Money(99))->lessThan(new Money(100)));
        $this->assertFalse((new Money(100))->lessThan(new Money(100)));
        $this->assertFalse((new Money(101))->lessThan(new Money(100)));
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::lessThanOrEquals
     */
    public function test_money_are_less_than_other_money_or_equal(): void
    {
        $this->assertTrue((new Money(99))->lessThanOrEquals(new Money(100)));
        $this->assertTrue((new Money(100))->lessThanOrEquals(new Money(100)));
        $this->assertFalse((new Money(101))->lessThanOrEquals(new Money(100)));
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::percent
     */
    public function test_gets_percentage_of_the_money(): void
    {
        $this->assertInstanceOf(MoneyPercent::class, (new Money(100))->percent(10));
        $this->assertSame(10, (new Money(100))->percent(10)->get()->inSubunits());
        $this->assertSame(10, (new Money(97))->percent(10)->get()->inSubunits());
        $this->assertSame(110, (new Money(100))->percent(110)->get()->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::multiplyBy
     */
    public function test_it_multiplies_money(): void
    {
        $money = new Money(1000);
        $result = $money->multiplyBy(5);

        $this->assertSame(5000, $result->inSubunits());
        $this->assertSame(1000, $money->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::divideBy
     */
    public function test_it_divides_money(): void
    {
        $money = new Money(1000);
        $result = $money->divideBy(2);

        $this->assertSame(500, $result->inSubunits());
        $this->assertSame(1000, $money->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::divideBy
     */
    public function test_it_divides_money_with_decimals(): void
    {
        $money = new Money(1000);
        $result = $money->divideBy(3);

        $this->assertSame(333, $result->inSubunits());
        $this->assertSame(1000/3, $result->getValue());
        $this->assertSame(1000, $money->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::isNegative
     */
    public function test_it_is_negative(): void
    {

        $moneyPositive = new Money(1000);
        $moneyNegative = new Money(-1);
        $moneyZero = new Money(0);

        $this->assertFalse($moneyPositive->isNegative());
        $this->assertTrue($moneyNegative->isNegative());
        $this->assertFalse($moneyZero->isNegative());

    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::isPositive
     */
    public function test_it_truncates_negative_money_to_zero(): void
    {

        $moneyPositive = new Money(1000);
        $moneyNegative = new Money(-1);
        $moneyZero = new Money(0);


        $this->assertSame(1000, $moneyPositive->truncateNegative()->inSubunits());
        $this->assertSame(0, $moneyNegative->truncateNegative()->inSubunits());
        $this->assertSame(0, $moneyZero->truncateNegative()->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::isNegative
     */
    public function test_it_checks_money_are_negative(): void
    {
        $negative = new Money(-1000);
        $positive = new Money(1000);
        $zero = new Money(0);

        $this->assertFalse($negative->isPositive());
        $this->assertTrue( $positive->isPositive());
        $this->assertFalse($zero->isPositive());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::sum
     */
    public function test_it_sums_money(): void
    {
        $negative = new Money(-500);
        $positive = new Money(1000);
        $zero = new Money(0);
        $other = new Money(444);

        $sum = Money::sum($negative, $positive, $zero, $other);

        $this->assertSame(-500, $negative->inSubunits());
        $this->assertSame(1000, $positive->inSubunits());
        $this->assertSame(0, $zero->inSubunits());
        $this->assertSame(444, $other->inSubunits());

        $this->assertSame(944, $sum->inSubunits());
    }

    /**
     * @covers \Moneybatch\Minimalist\Domain\Money::sum
     */
    public function test_it_fails_to_sum_non_money(): void
    {
        $integerValue = 1000;
        $moneyValue = new Money(-500);

        try {
            Money::sum($integerValue, $moneyValue);
        }
        catch (\TypeError $error) {
            $this->markTestSucceeded();
            return;
        }

        $this->fail('Expected to fail with the TypeError');

    }
}
