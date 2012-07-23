<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\CartInterface;

interface CartMapperInterface
{
    /**
     * Find the cart based on the cart ID
     *
     * @return CartInterface
     */
    public function findById($cartId);

    /**
     * Insert or update the cart in storage
     *
     * @param CartInterface cart to update
     * @return null
     */
    public function persist(CartInterface $cart);
}
