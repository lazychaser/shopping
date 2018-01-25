<?php

namespace Lazychaser\Shopping\Widgets\Options\TitleProviders;

use Lazychaser\Shopping\Contracts\Widgets\OptionsTitlesProvider;
use Lazychaser\Shopping\Support\AllowCaching;

class CachedTitles implements OptionsTitlesProvider
{
    use AllowCaching;
    
    /**
     * @var OptionsTitlesProvider
     */
    protected $provider;

    /**
     * CachedTitles constructor.
     *
     * @param OptionsTitlesProvider $provider
     */
    public function __construct(OptionsTitlesProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get options for given keys.
     *
     * `$key => $title` map.
     *
     * @param array $keys
     *
     * @return array
     */
    public function titlesForOptions(array $keys)
    {
        $cacheKey = $this->cacheKey($keys);

        return $this->remember($cacheKey, function () use ($keys) {
            return $this->provider->titlesForOptions($keys);
        });
    }

    /**
     * @param $keys
     *
     * @return string
     */
    protected function cacheKey($keys)
    {
        sort($keys);
        
        return 'options'.implode('.', $keys);
    }
}