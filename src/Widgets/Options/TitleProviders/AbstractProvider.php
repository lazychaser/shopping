<?php

namespace Kalnoy\Shopping\Widgets\Options\TitleProviders;

use Kalnoy\Shopping\Contracts\Widgets\OptionsTitlesProvider;
use Kalnoy\Shopping\Support\CreatesCachedVersion;

abstract class AbstractProvider implements OptionsTitlesProvider
{
    use CreatesCachedVersion;
    
    /**
     @inheritDoc
    */
    public function createCachedVersion()
    {
        return new CachedTitles($this);
    }

}