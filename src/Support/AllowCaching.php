<?php

namespace Lazychaser\Shopping\Support;

use Illuminate\Cache\CacheManager;
use Illuminate\Cache\Repository;

trait AllowCaching
{
    /**
     * @var int
     */
    protected $minutes = 60;

    /**
     * @var string
     */
    protected $cacheId;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @param int $value
     *
     * @return $this
     */
    public function minutes($value)
    {
        $this->minutes = $value;
        
        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function cacheTo($value)
    {
        $this->cacheId = $value;
        
        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function addSalt($value)
    {
        $this->salt = $value;
        
        return $this;
    }

    /**
     * @param string $key
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function remember($key, \Closure $callback)
    {
        if ($this->salt) $key .= $this->salt;
        
        return $this->getCacheStore()->remember($key, $this->minutes, $callback);
    }

    /**
     * @return Repository
     */
    public function getCacheStore()
    {
        return $this->getCacheManager()->store($this->cacheId);
    }

    /**
     * @param CacheManager $manager
     *
     * @return $this
     */
    public function setCacheManager(CacheManager $manager)
    {
        $this->cacheManager = $manager;
        
        return $this;
    }

    /**
     * @return CacheManager
     */
    public function getCacheManager()
    {
        return $this->cacheManager ?: app(CacheManager::class);
    }
}