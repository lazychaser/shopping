<?php

use Kalnoy\Shopping\Widgets\Twbs3\Wrappers\TabPane;
use Mockery as m;

class WidgetsTwbs3TabsTest extends PHPUnit_Framework_TestCase
{
    public function testTabPane()
    {
        $pane = new TabPane([ 'id' => 'id', 'inner' => 'content' ]);

        $this->assertEquals('id', $pane->getId());
        $this->assertEquals('content', $pane->render());

        $widget = m::mock(\Kalnoy\Shopping\Widgets\AbstractControlWidget::class);

        $widget->shouldReceive('getId')->andReturn('id');

        $pane = new TabPane([ 'inner' => $widget ]);

        $this->assertEquals('id', $pane->getId());
    }

    /**
     * @expectedException Exception
     */
    public function testFailsWhenNoIdSpecifiedForTab()
    {
        $pane = new TabPane();

        $pane->getId();
    }

    public function testTabPanesRendered()
    {
        $panes = new \Kalnoy\Shopping\Widgets\Twbs3\Wrappers\Tabs([
            'items' => [
                new TabPane([ 'id' => 'foo', 'inner' => 'Foo', 'title' => 'Foo label' ]),
                new TabPane([ 'id' => 'bar', 'inner' => 'Bar' ]),
            ],

            'activate' => 'bar',
            'nav_class' => 'nav',
            'tab_content_class' => 'content',
            'tab_pane_class' => 'pane',
                                                                  ]);

        $this->assertEquals('bar', $panes->getActivePane()->getId());

        $expected =
            '<div>'.PHP_EOL.
                '<ul class="nav">'.PHP_EOL.
                    '<li><a href="#foo" data-toggle="tab">Foo label</a></li>'.PHP_EOL.
                    '<li class="active"><a href="#bar" data-toggle="tab">bar</a></li>'.PHP_EOL.
                '</ul>'.PHP_EOL.
                '<div class="content">'.PHP_EOL.
                    '<div class="pane" id="foo">Foo</div>'.PHP_EOL.
                    '<div class="pane active" id="bar">Bar</div>'.PHP_EOL.
                '</div>'.PHP_EOL.
            '</div>';

        $this->assertEquals($expected, $panes->render());
    }
}