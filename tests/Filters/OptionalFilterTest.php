<?php

use Mockery as m;

class OptionalFilterTest extends PHPUnit_Framework_TestCase
{
    use RequiresBuilder;

    public function testBasics()
    {
        $filter = $this->getFilter();

        $this->assertFalse($filter->hasData());
        $this->assertFalse($filter->hasInput());
        $this->assertEquals('id', $filter->getId());
        $this->assertFalse($filter->shouldConstraint());
        $this->assertTrue($filter->hasValuableOptions());
        $this->assertNull($filter->optionFrequency('foo'));
    }

    public function testData()
    {
        $filter = $this->getFilter();

        $builder = $this->getBuilder();
        $filter->getProperty()->shouldReceive('values')->with($builder)->once()->andReturn([ 'foo' => 1, 'bar' => 2, 'baz' => 3 ]);

        $filter->collectData($builder);

        $this->assertEquals([ 'foo' => 1, 'bar' => 2, 'baz' => 3 ], $filter->getOptions());
        $this->assertTrue($filter->hasData());
        $this->assertTrue($filter->hasOptions());
        $this->assertTrue($filter->hasOptions(2));
        $this->assertFalse($filter->hasOptions(4));
        $this->assertFalse($filter->shouldConstraint());
        $this->assertTrue($filter->hasValuableOptions());
        $this->assertEquals(2, $filter->optionFrequency('bar'));
        $this->assertEquals(6, $filter->totalFrequency());

        $filter->getProperty()->shouldReceive('values')->with($builder)->once()->andReturn([ 'bar' => 2, 'baz' => 1 ]);

        $filter->collectValuableData($builder);

        $this->assertEquals([ 'bar' => 2, 'baz' => 1 ], $filter->getValuableOptions());
        $this->assertTrue($filter->hasValuableOptions());
        $this->assertFalse($filter->optionIsValuable('foo'));
        $this->assertTrue($filter->optionIsValuable('bar'));
        $this->assertEquals(0, $filter->optionFrequency('foo'));
        $this->assertEquals(2, $filter->optionFrequency('bar'));
        $this->assertEquals(null, $filter->optionFrequency('missing'));
        $this->assertEquals(3, $filter->totalFrequency());

        // Test when input has no data for the filter
        $filter->collectInput([ 'otherId' => 'otherData' ]);
        
        $this->assertFalse($filter->hasInput());
        $this->assertEquals([], $filter->getInput());
        $this->assertFalse($filter->inputHasValuableOptions());
        $this->assertFalse($filter->inputHasAllOptions());

        // bar is valuable, foo is not, missing is not on the list
        $filter->collectInput([ 'id' => [ 'foo', 'bar', 'missing' ] ]);

        $this->assertEquals([ 'foo', 'bar' ], $filter->getInput());
        $this->assertFalse($filter->inputHasAllOptions());
        $this->assertTrue($filter->hasInput());
        $this->assertTrue($filter->inputHasValuableOptions());
        $this->assertFalse($filter->inputHasOption('baz'));
        $this->assertTrue($filter->inputHasOption('foo'));
        $this->assertTrue($filter->shouldConstraint());

        // both valuable
        $filter->collectInput([ 'id' => [ 'bar', 'baz' ] ]);

        $this->assertTrue($filter->inputHasAllOptions());
        $this->assertFalse($filter->shouldConstraint());

        // none valuable
        $filter->collectInput([ 'id' => [ 'foo' ] ]);

        $this->assertFalse($filter->inputHasValuableOptions());
        $this->assertTrue($filter->shouldConstraint());
        
        $filter->getProperty()->shouldReceive('whereIn')->with($builder, [ 'foo' ])->once();
        
        $filter->applyToBuilder($builder);

    }

    public function testConstraintsWithoutValuableData()
    {
        $filter = $this->getFilter();

        $builder = $this->getBuilder();
        $filter->getProperty()->shouldReceive('values')->with($builder)->once()->andReturn([ 'foo' => 1, 'bar' => 2, 'baz' => 3 ]);

        $filter->collectData($builder);
        
        $filter->collectInput([ 'id' => [ 'foo' ] ]);
        
        $this->assertTrue($filter->shouldConstraint());
        
        $filter->collectInput([ 'id' => [ 'foo', 'bar', 'baz' ] ]);
        
        $this->assertFalse($filter->shouldConstraint());
    }

    public function getFilter()
    {
        $property = m::mock(\Kalnoy\Shopping\Contracts\Filters\Property::class);

        return new \Kalnoy\Shopping\Filters\Filters\OptionalFilter('id', $property);
    }
}