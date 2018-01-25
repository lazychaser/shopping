<?php

class WidgetsTwbs3Test extends PHPUnit_Framework_TestCase
{
    public function testRendersButtonCheckables()
    {
        $list = new \Lazychaser\Shopping\Widgets\Twbs3\ButtonCheckableList('id', [
            'items' => [
                new \Lazychaser\Shopping\Widgets\Options\Option('foo', 'Foo', null, false),
                new \Lazychaser\Shopping\Widgets\Options\Option('bar', 'Bar', 2, true),
            ],

            'buttonSize' => 'lg',
            'buttonType' => 'primary',
        ]);

        $expected =
            '<div class="CheckableButtonsFilter AppFilter--id btn-group btn-group-lg" data-toggle="buttons">'.PHP_EOL.
                '<label class="CheckableButtonsFilter__item value__foo checkbox btn btn-primary">'.PHP_EOL.
                    '<input type="checkbox" value="foo" name="id[]" id="id__foo">'.PHP_EOL.
                    '<span class="title">Foo</span>'.PHP_EOL.
                '</label>'.PHP_EOL.
                '<label class="CheckableButtonsFilter__item value__bar active checkbox btn btn-primary">'.PHP_EOL.
                    '<input type="checkbox" value="bar" name="id[]" id="id__bar" checked="checked">'.PHP_EOL.
                    '<span class="title">Bar</span><span class="frequency">2</span>'.PHP_EOL.
                '</label>'.PHP_EOL.
            '</div>';

        $this->assertEquals($expected, $list->render());
    }

    public function testRendersSelectControl()
    {
        $select = new \Lazychaser\Shopping\Widgets\Twbs3\SelectControl('id', [
            'size' => 'lg',
        ]);

        $expected = '<select class="SelectFilter AppFilter--id form-control input-lg" name="id">'.PHP_EOL.'</select>';

        $this->assertEquals($expected, $select->render());
    }
}