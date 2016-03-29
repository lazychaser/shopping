<?php

use Kalnoy\Shopping\Widgets\Options\TitleProviders\DatabaseTitles;
use Kalnoy\Shopping\Widgets\Options\TitleProviders\TitlesFromModel;
use Mockery as m;
use Illuminate\Support\Facades\Cache;

class WidgetsOptionsTitlesProvidersTest extends PHPUnit_Framework_TestCase
{
    use RequiresBuilder;

    public function testArrayOptions()
    {
        $options = new \Kalnoy\Shopping\Widgets\Options\TitleProviders\ArrayTitles([ 'foo' => 'bar', 'bar' => 'baz' ]);

        $this->assertEquals([ 'foo' => 'bar' ], $options->titlesForOptions([ 'foo', 'baz' ]));
    }

    public function testDatabaseOptions()
    {
        $builder = $this->getBuilder();
        $opts = new DatabaseTitles($builder, 'key', 'value');

        $builder->shouldReceive('whereIn')->once()->with('key', [ 'foo', 'bar' ])->andReturnSelf();
        $builder->shouldReceive('pluck')->once()->with('value', 'key')->andReturn('result');

        $this->assertEquals('result', $opts->titlesForOptions([ 'foo', 'bar' ]));
    }

    public function testOptionsFromModel()
    {
        $builder = m::mock(\Illuminate\Database\Query\Builder::class);

        $opts = new TitlesFromModel($builder, 'foo');

        $this->assertEquals($opts->newQuery(), $builder);

        $opts = new TitlesFromModel(TestModel::class, 'foo');

        $this->assertEquals($opts->newQuery(), 'fooBuilder');

        $model = m::mock(\Illuminate\Database\Eloquent\Model::class);

        $model->shouldReceive('newQuery')->andReturn($builder);

        $model->shouldReceive('getAttribute')->with('foo')->andReturn('title');

        $builder->shouldReceive('findMany')->with([ 'key' ], [ 'columns' ])->andReturnSelf();
        $builder->shouldReceive('getDictionary')->andReturn([ 'key' => $model ]);

        $opts = new TitlesFromModel($model, 'foo', [ 'columns' ]);

        $this->assertEquals($opts->newQuery(), $builder);
        $this->assertEquals($opts->titlesForOptions([ 'key' ]), [ 'key' => 'title' ]);

        $opts = new TitlesFromModel($model, function ($md) use ($model) {
            $this->assertEquals($model, $md);
        }, ['columns']);

        $opts->titlesForOptions([ 'key' ]);
    }

    public function testCachingOptions()
    {
        $provider = m::mock(\Kalnoy\Shopping\Contracts\Widgets\OptionsTitlesProvider::class);
        $opts = new \Kalnoy\Shopping\Widgets\Options\TitleProviders\CachedTitles($provider);

        $opts->minutes(33);

        $manager = m::mock(\Illuminate\Cache\CacheManager::class);
        $cache = m::mock(\Illuminate\Contracts\Cache\Repository::class);

        $opts->setCacheManager($manager);

        $manager->shouldReceive('store')->andReturn($cache);
        $manager->shouldReceive('store')->with('customStore')->andReturn($cache);

        $cache->shouldReceive('remember')->twice()->with('optionsbar.foo', 33, m::any());

        $cache->shouldReceive('remember')->once()->with('optionsbar.foosalt', 33, m::any());

        $opts->titlesForOptions([ 'foo', 'bar' ]);

        $opts->cacheTo('customStore');

        $opts->titlesForOptions([ 'bar', 'foo' ]);

        $opts->addSalt('salt');

        $opts->titlesForOptions([ 'bar', 'foo' ]);
    }
}

class TestModel extends \Illuminate\Database\Eloquent\Model
{
    public $builder = 'fooBuilder';

    public function newQuery()
    {
        return $this->builder;
    }
}