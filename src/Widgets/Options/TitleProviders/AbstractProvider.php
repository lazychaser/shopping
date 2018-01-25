<?php

namespace Lazychaser\Shopping\Widgets\Options\TitleProviders;

use Lazychaser\Shopping\Contracts\Widgets\OptionsTitlesProvider;
use Lazychaser\Shopping\Support\CreatesCachedVersion;

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