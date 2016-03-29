<?php

use Mockery as m;

class WidgetsLinkListTest extends PHPUnit_Framework_TestCase
{
    public function testHelperMethods()
    {
        $list = new \Kalnoy\Shopping\Widgets\LinkList('id');

        $list = $list->multiple(false)->html()->items('items')->baseUrl('url')
            ->params([ 'p1' => [ 'foo' ], 'p3' => [ 'foo' ] ])
            ->param('p1', [ 'bar' ])
            ->param('p2', 'bar')
            ->param('p3', 'bar');

        $this->assertEquals(false, $list->multiple);
        $this->assertEquals(true, $list->html);
        $this->assertEquals('items', $list->items);
        $this->assertEquals([ 'p1' => [ 'foo', 'bar' ], 'p2' => 'bar', 'p3' => [ 'foo', 'bar' ] ], $list->params);
        $this->assertEquals('url', $list->baseUrl);
    }

    public function testRendersNonMultipleOptionsWithNoHtml()
    {
        $ll = new \Kalnoy\Shopping\Widgets\LinkList('id', [
            'items' => [
                new \Kalnoy\Shopping\Widgets\Options\Option('foo', 'Foo>', null, false),
                new \Kalnoy\Shopping\Widgets\Options\Option('bar', 'Bar', 2, true),
                new \Kalnoy\Shopping\Widgets\Options\Option('baz', 'Baz', 0, false),
                new \Kalnoy\Shopping\Widgets\Options\Option(null, 'Reset', null, false),
            ],

            'params' => [ 'id' => 'bar', 'cp' => 'value' ],

            'base_url' => 'url',
            'multiple' => false,
        ]);

        $expected =
            '<ul class="LinksFilter AppFilter--id">'.PHP_EOL.
                '<li class="LinksFilter__item value__foo"><a href="url?cp=value&amp;id=foo">Foo&gt;</a></li>'.PHP_EOL.
                '<li class="LinksFilter__item value__bar LinksFilter__item--active"><a href="url?cp=value">Bar</a><span class="frequency">2</span></li>'.PHP_EOL.
                '<li class="LinksFilter__item value__baz LinksFilter__item--disabled"><a href="url?cp=value&amp;id=baz">Baz</a></li>'.PHP_EOL.
                '<li class="LinksFilter__item"><a href="url?cp=value">Reset</a></li>'.PHP_EOL.
            '</ul>';

        $this->assertEquals($expected, $ll->render());
    }

    public function testRendersMultipleOptions()
    {
        $ll = new \Kalnoy\Shopping\Widgets\LinkList('id', [
            'items' => [
                new \Kalnoy\Shopping\Widgets\Options\Option('foo', 'Foo', null, true),
                new \Kalnoy\Shopping\Widgets\Options\Option('bar', 'Bar', null, false),
            ],

            'params' => [ 'id' => [ 'foo' ] ],
            'base_url' => 'url',
        ]);

        $expected =
            '<ul class="LinksFilter AppFilter--id">'.PHP_EOL.
                '<li class="LinksFilter__item value__foo LinksFilter__item--active"><a href="url">Foo</a></li>'.PHP_EOL.
                '<li class="LinksFilter__item value__bar"><a href="url?id%5B0%5D=foo&amp;id%5B1%5D=bar">Bar</a></li>'.PHP_EOL.
            '</ul>';

        $this->assertEquals($expected, $ll->render());
    }

    public function testRendersWithHtmlAllowed()
    {
        $ll = new \Kalnoy\Shopping\Widgets\LinkList('id', [
            'items' => [
                new \Kalnoy\Shopping\Widgets\Options\Option('foo', '<b>Foo</b>', null, false),
            ],

            'base_url' => 'url',
            'html' => true,
            'multiple' => false,
        ]);

        $expected =
            '<ul class="LinksFilter AppFilter--id">'.PHP_EOL.
                '<li class="LinksFilter__item value__foo"><a href="url?id=foo"><b>Foo</b></a></li>'.PHP_EOL.
            '</ul>';

        $this->assertEquals($expected, $ll->render());
    }

    public function testGetsBaseUrlFromRequest()
    {
        $ll = new \Kalnoy\Shopping\Widgets\LinkList('id', [
            'items' => [
                new \Kalnoy\Shopping\Widgets\Options\Option('foo', 'Foo'),
            ],
            'multiple' => false,
        ]);

        $request = m::mock(\Illuminate\Http\Request::class);

        $request->shouldReceive('url')->andReturn('url');
        $request->shouldReceive('get')->with('id')->andReturn([]);

        $ll->setRequest($request);

        $expected =
            '<ul class="LinksFilter AppFilter--id">'.PHP_EOL.
                '<li class="LinksFilter__item value__foo"><a href="url?id=foo">Foo</a></li>'.PHP_EOL.
            '</ul>';

        $this->assertEquals($expected, $ll->render());
    }

    public function testAltLinkListRenders()
    {
        $ll = new \Kalnoy\Shopping\Widgets\AltLinkList('id', [
            'items' => [
                new \Kalnoy\Shopping\Widgets\Options\Option('foo', 'Foo', null, false),
                new \Kalnoy\Shopping\Widgets\Options\Option('bar', 'Bar', 2, true),
            ],

            'multiple' => false,
            'base_url' => 'url',
        ]);

        $expected =
            '<div class="AltLinksFilter AppFilter--id">'.PHP_EOL.
                '<a href="url?id=foo" class="AltLinksFilter__item value__foo">Foo</a>'.PHP_EOL.
                '<a href="url" class="AltLinksFilter__item value__bar AltLinksFilter__item--active">Bar<span class="frequency">2</span></a>'.PHP_EOL.
            '</div>';

        $this->assertEquals($expected, $ll->render());
    }
}