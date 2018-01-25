<?php

use Mockery as m;

class WidgetsTwbs3FormGroupTest extends PHPUnit_Framework_TestCase
{
    public function testRendersBasicContent()
    {
        $control = new \Lazychaser\Shopping\Widgets\Twbs3\Wrappers\FormGroup([ 'inner' => 'Foo content', 'label' => 'Foo' ]);

        $expected =
            '<div class="form-group">'.PHP_EOL.
                '<label>Foo</label>'.PHP_EOL.
                'Foo content'.
            '</div>';

        $this->assertEquals($expected, $control->render());
    }

    public function testRendersWithWidget()
    {
        $widget = m::mock(\Lazychaser\Shopping\Widgets\AbstractWidget::class);

        $widget->shouldReceive('getId')->andReturn('id');
        $widget->shouldReceive('render')->andReturn('content');

        $control = new \Lazychaser\Shopping\Widgets\Twbs3\Wrappers\FormGroup([
            'inner' => $widget,
            'label' => 'Label',
                                                                         ]);

        $expected =
            '<div class="form-group">'.PHP_EOL.
                '<label for="id">Label</label>'.PHP_EOL.
                'content'.
            '</div>';

        $this->assertEquals($expected, $control->render());
    }
}