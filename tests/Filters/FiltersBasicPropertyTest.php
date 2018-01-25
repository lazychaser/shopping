<?php

use Illuminate\Database\Query\Builder;
use Lazychaser\Shopping\Filters\Properties\BasicProperty;
use Mockery as m;

class FiltersBasicPropertyTest extends PHPUnit_Framework_TestCase
{
    use RequiresBuilder;
    
    public function testValues()
    {
        $prop = $this->getProperty();
        $builder = $this->getBuilder();

        $builder->shouldReceive('selectRaw')->once()->with('case when "id" is null then \''.BasicProperty::NULL_VALUE.'\' else "id" end as value');
        $builder->shouldReceive('selectRaw')->once()->with('count(1) as count');
        $builder->shouldReceive('pluck')->andReturn('foo');

        $this->assertEquals('foo', $prop->values($builder));
    }

    public function testRange()
    {
        $prop = $this->getProperty();
        $builder = $this->getBuilder();

        $builder->shouldReceive('selectRaw')->once()->with('min("id") as min');
        $builder->shouldReceive('selectRaw')->once()->with('max("id") as max');
        $builder->shouldReceive('first')->once()->andReturn([ 'min' => 'foo', 'max' => 'bar' ]);

        $this->assertEquals([ 'foo', 'bar' ], $prop->range($builder));
    }

    public function testWhere()
    {
        $prop = $this->getProperty();
        $builder = $this->getBuilder();

        $builder->shouldReceive('where')->once()->with('id', '>', 'foo');
        $builder->shouldReceive('where')->once()->with('id', '=', null);

        $prop->where($builder, 'foo', '>');
        $prop->where($builder, BasicProperty::NULL_VALUE);
    }

    public function testWhereIn()
    {
        $prop = $this->getProperty();

        $builder = $this->getBuilder()->from('table');

        $prop->whereIn($builder, [ 'foo', 'bar' ]);

        $this->assertEquals('select * from "table" where "id" in (?, ?)', $builder->toSql());

        $builder = $this->getBuilder()->from('table');

        $prop->whereIn($builder, [ BasicProperty::NULL_VALUE, 'bar' ]);

        $this->assertEquals('select * from "table" where ("id" in (?) or "id" is null)', $builder->toSql());

        $builder = $this->getBuilder()->from('table');

        $prop->whereIn($builder, [ 'foo' ]);

        $this->assertEquals('select * from "table" where "id" = ?', $builder->toSql());
    }

    public function testBetween()
    {
        $prop = $this->getProperty();
        $builder = $this->getBuilder();

        $builder->shouldReceive('whereBetween')->once()->with('id', [ 'foo', 'bar' ])->andReturn($builder);
        $builder->shouldReceive('orWhereNull')->andReturn('baz');

        $this->assertEquals('baz', $prop->whereBetween($builder, [ 'foo', 'bar' ]));
    }

    /**
     * @return BasicProperty
     */
    protected function getProperty()
    {
        return new BasicProperty('id');
    }
}