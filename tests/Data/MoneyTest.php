<?php

use Kalnoy\Shopping\Data\Money;
use Mockery as m;

class MoneyTest extends PHPUnit_Framework_TestCase
{
    public function testCreates()
    {
        $m = Money::raw(102);

        $this->assertEquals(1.02, $m->toFloat());

        $m1 = new Money(102);

        $this->assertEquals($m1->toFloat(), $m->toFloat());

        $m = Money::fromFloat(1.23);

        $this->assertEquals(1.23, $m->toFloat());

        $this->assertEquals(1, $m->omitCents()->toFloat());
    }

    public function testMath()
    {
        $a = new Money(100);
        $b = new Money(50);

        $sum = $a->add($b);
        $sub = $a->sub($b);
        $mul = $a->mul(0.33);
        $div = $a->div(3);

        $this->assertEquals(1.5, $sum->toFloat());
        $this->assertEquals(0.5, $sub->toFloat());
        $this->assertEquals(0.33, $mul->toFloat());
        $this->assertEquals(0.33, $div->toFloat());
    }

    public function testCompare()
    {
        $a = new Money(100);
        $b = new Money(50);

        $this->assertTrue($a->gt($b));
        $this->assertFalse($a->lt($b));
        $this->assertTrue($a->gte($b));
        $this->assertFalse($a->eq($b));
        $this->assertTrue($a->eq($a));

        $this->assertFalse($b->gt($a));
        $this->assertTrue($b->lt($a));
        $this->assertFalse($b->gte($a));
        $this->assertTrue($b->lte($a));
    }

    public function testPercentage()
    {
        $p = m::mock(new \Kalnoy\Shopping\Data\Percents(15));

        $p->shouldReceive('toMultiplier')->once()->andReturn(0.15);
        $p->shouldReceive('calcPercentage')->times(3)->andReturn(15);

        $m = new Money(100);

        $sum = $m->add($p);
        $sub = $m->sub($p);
        $mul = $m->mul($p);
        $discount = $m->discount($p);

        $this->assertEquals(1.15, $sum->toFloat());
        $this->assertEquals(0.85, $sub->toFloat());
        $this->assertEquals(0.15, $mul->toFloat());
        $this->assertEquals(0.85, $discount->toFloat());
    }

    /**
     * @depends testMath
     */
    public function testRounding()
    {
        $m = new Money(100);

        $mul1 = $m->mul(0.124);
        $mul2 = $m->mul(0.125);

        $this->assertEquals(0.12, $mul1->toFloat());
        $this->assertEquals(0.13, $mul2->toFloat());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvaliadOperands()
    {
        $m = new Money(100);

        $m->add(123);
    }
}