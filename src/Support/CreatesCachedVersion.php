<?php

namespace Lazychaser\Shopping\Support;

trait CreatesCachedVersion
{
    /**
     * @return mixed
     */
    abstract public function createCachedVersion();

    /**
     * @param int $minutes
     * @param string $salt
     * @param string $cache
     *
     * @return mixed
     */
    public function cached($minutes = 60, $salt = null, $cache = null)
    {
        return $this->createCachedVersion()
                    ->minutes($minutes)
                    ->addSalt($salt)
                    ->cacheTo($cache);
    }
}