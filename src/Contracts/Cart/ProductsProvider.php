<?php

namespace Kalnoy\Shopping\Contracts\Cart;

use Kalnoy\Shopping\Contracts\Commerce\Product;

/**
 * SessionCart item provider interface.
 */
interface ProductsProvider
{
    /**
     * Get cart items by id.
     *
     * @param array $ids
     *
     * @return Product[]|\Illuminate\Support\Collection
     */
    public function getCartItemsByIdList(array $ids);

    /**
     * @param mixed $id
     *
     * @return Product
     */
    public function getCartItemById($id);

}