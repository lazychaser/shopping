<?php

use Lazychaser\Shopping\Widgets\Options\Option;
use Lazychaser\Shopping\Widgets\Select;
use Mockery as m;

class WidgetsSelectTest extends PHPUnit_Framework_TestCase
{
    public function testRendersSingleSelect()
    {
        $select = new Select('id', [
            'items' => [
                new Option('foo>', 'Foo'),
                new Option('bar', 'Bar>', 2, true),
                [ 'value' => 'baz', 'title' => 'Baz' ],
            ],
        ]);

        $this->assertEquals('id', $select->getId());

        $request = m::mock(\Illuminate\Http\Request::class);

        $request->shouldReceive('get')->with('id')->andReturn('baz');

        $select->setRequest($request);

        $expected =
            '<select class="SelectFilter AppFilter--id" name="id">'.PHP_EOL.
                '<option value="foo&gt;">Foo</option>'.PHP_EOL.
                '<option value="bar" selected="selected">Bar&gt; [2]</option>'.PHP_EOL.
                '<option value="baz" selected="selected">Baz</option>'.PHP_EOL.
            '</select>';

        $this->assertEquals($expected, $select->render());
    }

    public function testRendersMultiple()
    {
        $select = new Select('id');

        $select->multiple();

        $this->assertEquals('<select class="SelectFilter AppFilter--id" name="id" multiple="multiple">'.PHP_EOL.'</select>', (string)$select);
    }

    public function testGetsOptionsFromProvider()
    {
        $provider = m::mock(\Lazychaser\Shopping\Contracts\Widgets\OptionsBuilder::class);

        $provider->shouldReceive('options')->andReturn([ [ 'value' => 'bar', 'title' => 'Bar', 'active' => false ] ]);

        $select = new Select('id', [ 'items' => $provider ]);

        $expected =
            '<select class="SelectFilter AppFilter--id" name="id">'.PHP_EOL.
                '<option value="bar">Bar</option>'.PHP_EOL.
            '</select>';

        $this->assertEquals($expected, $select->render());
    }

    public function testFrequencyNotDisplayedWhenDisabled()
    {
        $select = new Select('id', [
            'items' => [
                new Option('bar', 'Bar', 2, true),
            ],
        ]);

        $select->hideFrequency();

        $expected =
            '<select class="SelectFilter AppFilter--id" name="id">'.PHP_EOL.
                '<option value="bar" selected="selected">Bar</option>'.PHP_EOL.
            '</select>';

        $this->assertEquals($expected, $select->render());
    }
}