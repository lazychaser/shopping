<?php

use Illuminate\Database\Query\Builder;
use Mockery as m;

trait RequiresBuilder
{
    protected function getBuilder()
    {
        $grammar = new Illuminate\Database\Query\Grammars\Grammar;
        $processor = m::mock('Illuminate\Database\Query\Processors\Processor');

        return m::mock(new Builder(m::mock('Illuminate\Database\ConnectionInterface'), $grammar, $processor));
    }
}