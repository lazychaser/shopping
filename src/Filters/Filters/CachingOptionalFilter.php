<?php

namespace Lazychaser\Shopping\Filters\Filters;

use Illuminate\Database\Query\Builder;
use Lazychaser\Shopping\Support\AllowCaching;

class CachingOptionalFilter extends OptionalFilter
{
    use AllowCaching;

    /**
     * @inheritDoc
     */
    public function collectData(Builder $query)
    {
        $this->options = $this->remember($this->id.'_options',
            function () use ($query) { return $this->property->values($query); }
        );
    }

}