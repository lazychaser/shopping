<?php

namespace Lazychaser\Shopping\Contracts\Cart;

interface Requirement
{
    /**
     * @param Cart $cart
     *
     * @return bool
     */
    public function satisfied(Cart $cart);

    /**
     * @return string
     */
    public function getId();
}