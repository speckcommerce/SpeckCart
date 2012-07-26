<?php

namespace SpeckCart\Entity;

use DateTime;

interface CartInterface extends ItemCollectionInterface
{
    /**
     * Get this cart's ID
     *
     * @return int
     */
    public function getCartId();

    /**
     * Set this cart's ID
     *
     * @return CartInterface
     */
    public function setCartId($cartId);

    /**
     * Get the cart's creation time
     *
     * @return DateTime
     */
    public function getCreatedTime();

    /**
     * Set the cart's creation time
     *
     * @param DateTime creation time
     * @return CartInterface
     */
    public function setCreatedTime(DateTime $time);
}
