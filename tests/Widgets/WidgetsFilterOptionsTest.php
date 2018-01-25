<?php

use Lazychaser\Shopping\Filters\Filters\OptionalFilter;
use Lazychaser\Shopping\Widgets\Options\OptionsFromFilter;
use Lazychaser\Shopping\Widgets\Options\Option;
use Mockery as m;

class WidgetsFilterOptionsTest extends PHPUnit_Framework_TestCase
{
    public function testOptionClass()
    {
        $option = new Option('foo', 'bar', 2, false);

        $this->assertEquals('foo', $option->getValue());
        $this->assertEquals('bar', $option->getTitle());
        $this->assertEquals(2, $option->getFrequency());
        $this->assertEquals(false, $option->isActive());
    }

    public function testOptionCreatedFromArray()
    {
        $option = Option::fromArray([ 'value' => 'foo', 'title' => 'bar', 'frequency' => 2, 'active' => false ]);

        $this->assertEquals('foo', $option->getValue());
        $this->assertEquals('bar', $option->getTitle());
        $this->assertEquals(2, $option->getFrequency());
        $this->assertEquals(false, $option->isActive());
    }

    public function testConfigures()
    {
        OptionsFromFilter::$defaultNullValueLabel = 'default';

        $builder = new OptionsFromFilter(m::mock(OptionalFilter::class));

        $this->assertEquals('default', $builder->getNullValueLabel());

        $provider = m::mock(\Lazychaser\Shopping\Contracts\Widgets\OptionsTitlesProvider::class);

        $builder->nullValueLabel('foo')->addPrompt('bar')->titlesFrom($provider);

        $this->assertEquals('foo', $builder->nullValueLabel);
        $this->assertEquals('bar', $builder->prompt);
        $this->assertEquals($provider, $builder->titlesProvider);
    }

    public function testWithNoProvider()
    {
        $filter = m::mock(OptionalFilter::class);

        $filter->shouldReceive('getOptions')->andReturn([ 'foo' => 1, 'bar' => 2 ]);
        $filter->shouldReceive('optionFrequency')->with('foo')->andReturn(1);
        $filter->shouldReceive('inputHasOption')->with('foo')->andReturn(false);
        $filter->shouldReceive('optionFrequency')->with('bar')->andReturn(2);
        $filter->shouldReceive('inputHasOption')->with('bar')->andReturn(true);

        $builder = new OptionsFromFilter($filter);

        $options = $builder->options();

        $this->assertCount(2, $options);

        $option = array_shift($options);

        $this->assertEquals('bar', $option->getValue());
        $this->assertEquals('bar', $option->getTitle());
        $this->assertEquals(2, $option->getFrequency());
        $this->assertTrue($option->isActive());
    }

    public function testWithProvider()
    {
        $filter = m::mock(OptionalFilter::class);

        $filter->shouldReceive('getOptions')->andReturn([ 'foo' => 1, 'bar' => 2 ]);
        $filter->shouldReceive('optionFrequency')->with('foo')->andReturn(1);
        $filter->shouldReceive('inputHasOption')->with('foo')->andReturn(false);
        $filter->shouldReceive('optionFrequency')->with('bar')->andReturn(2);
        $filter->shouldReceive('inputHasOption')->with('bar')->andReturn(true);

        $provider = m::mock(\Lazychaser\Shopping\Contracts\Widgets\OptionsTitlesProvider::class);

        $provider->shouldReceive('titlesForOptions')->andReturn([ 'bar' => 'Bar', 'foo' => 'Foo' ]);

        $builder = new OptionsFromFilter($filter, $provider);

        $options = $builder->options();

        $this->assertCount(2, $options);

        $option = array_shift($options);

        $this->assertEquals('bar', $option->getValue());
        $this->assertEquals('Bar', $option->getTitle());
    }

    public function testPrompt()
    {
        $filter = m::mock(OptionalFilter::class);

        $filter->shouldReceive('getOptions')->andReturn([ 'foo' => 1 ]);
        $filter->shouldReceive('optionFrequency')->with('foo')->andReturn(1);
        $filter->shouldReceive('inputHasOption')->with('foo')->andReturn(false);

        $builder = new OptionsFromFilter($filter, null, 'Prompt');

        $options = $builder->options();

        $option = array_shift($options);

        $this->assertEquals(null, $option->getValue());
        $this->assertEquals('Prompt', $option->getTitle());
        $this->assertNull($option->getFrequency());
        $this->assertNull($option->isActive());
    }

    public function testWithPromptAndNullValue()
    {
        $filter = m::mock(OptionalFilter::class);

        $null = \Lazychaser\Shopping\Filters\Properties\BasicProperty::NULL_VALUE;

        $filter->shouldReceive('getOptions')->andReturn([ $null => 1 ]);
        $filter->shouldReceive('optionFrequency')->with($null)->andReturn(1);
        $filter->shouldReceive('inputHasOption')->with($null)->andReturn(false);

        $builder = new OptionsFromFilter($filter, null, 'Prompt', 'Null');

        $options = $builder->options();

        $option = array_shift($options);

        $this->assertEquals('Prompt', $option->getTitle());

        $option = array_shift($options);

        $this->assertEquals($null, $option->getValue());
        $this->assertEquals('Null', $option->getTitle());
    }
}