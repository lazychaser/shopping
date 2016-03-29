<?php

class WidgetsTwbs3ButtonDropdownTest extends PHPUnit_Framework_TestCase
{
    public function testHelperSetters()
    {
        $list = new \Kalnoy\Shopping\Widgets\Twbs3\ButtonDropdown('id');
        
        $list = $list->title('title')->glue('glue');
        
        $this->assertEquals('title', $list->title);
        $this->assertEquals('glue', $list->glue);
    }
    
    public function testRendersTitleWhenNoActiveOptions()
    {
        $list = new \Kalnoy\Shopping\Widgets\Twbs3\ButtonDropdown('id', [
            'title' => 'Title',
            'buttonSize' => 'lg',
            'buttonType' => 'primary',
        ]);

        $expected =
            '<div class="DropdownButtonFilter AppFilter--id btn-group btn-group-lg">'.PHP_EOL.
                '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Title <span class="caret"></span></button>'.PHP_EOL.
                '<ul class="dropdown-menu">'.PHP_EOL.'</ul>'.PHP_EOL.
            '</div>';

        $this->assertEquals($expected, $list->render());
    }

    public function testRendersMultipleSelection()
    {
        $list = new \Kalnoy\Shopping\Widgets\Twbs3\ButtonDropdown('id', [
            'items' => [
                new \Kalnoy\Shopping\Widgets\Options\Option('foo', 'Foo', null, true),
                new \Kalnoy\Shopping\Widgets\Options\Option('bar', 'Bar', 2, true),
                new \Kalnoy\Shopping\Widgets\Options\Option('baz', 'Baz', 0, false),
            ],

            'multiple' => true,
            'baseUrl' => 'url',
        ]);

        $expected =
            '<div class="DropdownButtonFilter AppFilter--id btn-group">'.PHP_EOL.
                '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Foo, Bar <span class="caret"></span></button>'.PHP_EOL.
                '<ul class="dropdown-menu">'.PHP_EOL.
                    '<li class="DropdownButtonFilter__item value__foo active">'.PHP_EOL.
                        '<a href="url?id%5B0%5D=bar">Foo</a>'.PHP_EOL.
                    '</li>'.PHP_EOL.
                    '<li class="DropdownButtonFilter__item value__bar active">'.PHP_EOL.
                        '<a href="url?id%5B0%5D=foo">Bar<span class="badge">2</span></a>'.PHP_EOL.
                    '</li>'.PHP_EOL.
                    '<li class="DropdownButtonFilter__item value__baz disabled">'.PHP_EOL.
                        '<a href="url?id%5B0%5D=foo&amp;id%5B1%5D=bar&amp;id%5B2%5D=baz">Baz</a>'.PHP_EOL.
                    '</li>'.PHP_EOL.
                '</ul>'.PHP_EOL.
            '</div>';

        $this->assertEquals($expected, $list->render());
    }
}