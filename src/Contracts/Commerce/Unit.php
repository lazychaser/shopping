<?php

namespace Kalnoy\Shopping\Contracts\Commerce;

interface Unit
{
    public function format($value);

    public function getName();

    public function getSymbol();

    public function getCodeName();
}