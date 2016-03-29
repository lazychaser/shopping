<?php

use Kalnoy\Shopping\Support\Helpers;

class SupportHelpersTest extends PHPUnit_Framework_TestCase
{
    public function testConfigures()
    {
        $obj = new SupportConfigurableClass;

        Helpers::configure($obj, [ 'bar' => 'bar', 'baz' => 'baz' ]);

        $this->assertEquals('bar', $obj->bar);
        $this->assertEquals('baz', $obj->getBaz());
    }

    /**
     * @expectedException Error
     */
    public function testConfigureFailsOnPrivateProperty()
    {
        $obj = new SupportConfigurableClass();

        Helpers::configure($obj, [ 'foo' => 'foo' ]);
    }
}

class SupportConfigurableClass
{
    protected $foo;

    public $bar;

    protected $baz;

    public function setBaz($value)
    {
        $this->baz = $value;
    }

    public function getBaz()
    {
        return $this->baz;
    }

}