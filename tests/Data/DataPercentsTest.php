<?php

use Lazychaser\Shopping\Data\Percents;

class DataPercentsTest extends PHPUnit_Framework_TestCase
{
    public function testPercentage()
    {
        $value = new Percents(15);

        $this->assertEquals(0.15, $value->toMultiplier());
        $this->assertEquals(15, $value->calcPercentage(100));
    }
}