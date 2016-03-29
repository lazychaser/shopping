<?php

use Kalnoy\Shopping\Contracts\Filters\Filter;
use Kalnoy\Shopping\Filters\Collection;
use Mockery as m;

class FiltersCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testAddition()
    {
        $coll = new Collection();

        $filter = $this->getFilter();

        $coll->add($filter);

        $this->assertSame($filter, $coll->get('id'));
        $this->assertTrue($coll->has($filter));
        $this->assertTrue($coll->has('id'));
        $this->assertFalse($coll->has('missing'));
        $this->assertTrue(isset($coll['id']));
        $this->assertCount(1, $coll);

        $coll['foo'] = 'bar';
        $this->assertEquals('bar', $coll['foo']);

        unset($coll['foo']);

        $this->assertFalse($coll->has('foo'));

        $this->assertEquals('default', $coll->get('missing', 'default'));

        $coll[] = $this->getFilter('bar');
        $this->assertTrue(isset($coll['bar']));
    }

    public function testCreation()
    {
        $filter1 = $this->getFilter('foo');
        $filter2 = $this->getFilter('bar');

        $coll = new Collection([ $filter1, $filter2 ]);

        $this->assertCount(2, $coll);
        $this->assertTrue(isset($coll['foo']));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFailsToAddSameFilter()
    {
        $filter = $this->getFilter();

        $coll = new Collection([ $filter ]);

        $coll->add($filter);
    }

    public function testIterator()
    {
        $filter1 = $this->getFilter('foo');
        $filter2 = $this->getFilter('bar');

        $coll = new Collection([ $filter1, $filter2 ]);

        $data = [];

        foreach ($coll as $filter) $data[] = $filter;

        $this->assertEquals([ $filter1, $filter2 ], $data);
    }

    public function testConstraintsWithoutInput()
    {
        $foo = $this->getFilter('foo');
        $bar = $this->getFilter('bar');

        $builder = m::mock(\Illuminate\Database\Query\Builder::class);
        $input = [ 'input' ];

        $foo->shouldReceive('collectData')->once();
        $bar->shouldReceive('collectData')->once();

        $foo->shouldReceive('collectInput')->with($input)->once()->andReturn(false);
        $bar->shouldReceive('collectInput')->with($input)->once()->andReturn(false);

        $foo->shouldNotReceive('applyToBuilder');
        $bar->shouldNotReceive('applyToBuilder');

        $coll = new Collection([ $foo, $bar ]);

        $coll->applyToBuilder($builder, $input);
    }

    public function testConstraintsWithInput()
    {
        $foo = $this->getFilter('foo');
        $bar = $this->getFilter('bar');

        $builder = m::mock(\Illuminate\Database\Query\Builder::class);
        $input = [ 'input' ];

        $foo->shouldReceive('collectData')->once();
        $bar->shouldReceive('collectData')->once();

        $foo->shouldReceive('collectInput')->with($input)->once()->andReturn(true);
        $bar->shouldReceive('collectInput')->with($input)->once()->andReturn(true);

        $foo->shouldReceive('collectValuableData')->once();
        $bar->shouldReceive('collectValuableData')->once();

        $foo->shouldReceive('applyToBuilder')->twice();
        $bar->shouldReceive('applyToBuilder')->twice();

        $called = false;

        $coll = new Collection([ $foo, $bar ]);

        $result = $coll->applyToBuilder($builder, $input, function ($param) use (&$called, $builder) {
            $called = true;
            $this->assertEquals($builder, $param);
        } );

        $this->assertEquals($builder, $result);
    }

    public function testWithoutValuableData()
    {
        $foo = $this->getFilter('foo');
        $bar = $this->getFilter('bar');

        $builder = m::mock(\Illuminate\Database\Query\Builder::class);
        $input = [ 'input' ];

        $foo->shouldReceive('collectData')->once();
        $bar->shouldReceive('collectData')->once();

        $foo->shouldReceive('collectInput')->with($input)->once()->andReturn(true);
        $bar->shouldReceive('collectInput')->with($input)->once()->andReturn(true);

        $foo->shouldNotReceive('collectValuableData');
        $bar->shouldNotReceive('collectValuableData');

        $foo->shouldReceive('applyToBuilder')->once();
        $bar->shouldReceive('applyToBuilder')->once();

        $coll = new Collection([ $foo, $bar ]);

        $coll->collectValuableData = false;

        $coll->applyToBuilder($builder, $input);
    }

    /**
     * @return m\MockInterface
     */
    protected function getFilter($id = 'id')
    {
        $filter = m::mock(Filter::class);

        $filter->shouldReceive('getId')->andReturn($id);

        return $filter;
    }

}