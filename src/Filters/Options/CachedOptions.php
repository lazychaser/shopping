<?php

namespace Kalnoy\Shopping\Filters\Options;

use Kalnoy\Shopping\Contracts\Filters\OptionsProvider;
use Kalnoy\Shopping\Filters\AllowCaching;

class CachedOptions implements OptionsProvider
{
    use AllowCaching;
    
    /**
     * @var OptionsProvider
     */
    protected $provider;

    /**
     * CachedOptions constructor.
     *
     * @param OptionsProvider $provider
     */
    public function __construct(OptionsProvider $provider)
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
    public function options(array $keys)
    {
        $cacheKey = $this->cacheKey($keys);

        return $this->remember($cacheKey, function () use ($keys) {
            return $this->provider->options($keys);
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