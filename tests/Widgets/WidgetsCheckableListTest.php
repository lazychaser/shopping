<?php

class WidgetsCheckableListTest extends PHPUnit_Framework_TestCase
{
    public function testRendersCheckboxes()
    {
        $list = new \Lazychaser\Shopping\Widgets\CheckableList('id', [
            'items' => [
                new \Lazychaser\Shopping\Widgets\Options\Option('foo', 'Foo>', null, false),
                new \Lazychaser\Shopping\Widgets\Options\Option('bar', 'Bar', 2, true),
            ],
        ]);

        $expected = '<ul class="CheckableFilter AppFilter--id">'.PHP_EOL.
            '<li class="CheckableFilter__item value__foo CheckableFilter__item--checkbox"><label>'.PHP_EOL.
                '<input type="checkbox" value="foo" name="id[]" id="id__foo">'.PHP_EOL.
                '<span class="title">Foo&gt;</span>'.PHP_EOL.
            '</label></li>'.PHP_EOL.

            '<li class="CheckableFilter__item value__bar CheckableFilter__item--active CheckableFilter__item--checkbox"><label>'.PHP_EOL.
                '<input type="checkbox" value="bar" name="id[]" id="id__bar" checked="checked">'.PHP_EOL.
                '<span class="title">Bar</span><span class="frequency">2</span>'.PHP_EOL.
            '</label></li>'.PHP_EOL.
        '</ul>';

        $this->assertEquals($expected, $list->render());
    }

    public function testRendersRadios()
    {
        $list = new \Lazychaser\Shopping\Widgets\CheckableList('id', [
            'items' => [
                new \Lazychaser\Shopping\Widgets\Options\Option('foo', '<b>Foo</b>', null, false),
            ],

            'multiple' => false,
            'html' => true,
        ]);

        $expected =
            '<ul class="CheckableFilter AppFilter--id">'.PHP_EOL.
                '<li class="CheckableFilter__item value__foo CheckableFilter__item--radio"><label>'.PHP_EOL.
                    '<input type="radio" value="foo" name="id" id="id__foo">'.PHP_EOL.
                    '<span class="title"><b>Foo</b></span>'.PHP_EOL.
                '</label></li>'.PHP_EOL.
            '</ul>';

        $this->assertEquals($expected, $list->render());
    }
}