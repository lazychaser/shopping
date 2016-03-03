<?php

namespace Kalnoy\Shopping\Filters\Filters;

use Illuminate\Database\Query\Builder;
use Kalnoy\Shopping\Filters\AllowCaching;

class CachingOptionalFilter extends OptionalFilter
{
    use AllowCaching;

    /**
     * @inheritDoc
     */
    public function gatherData(Builder $query)
    {
        $this->options = $this->remember($this->id.'_options',
            function () use ($query) { return $this->property->values($query); }
        );
    }

}