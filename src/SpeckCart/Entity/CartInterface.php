<?php

namespace SpeckCart\Entity;

use DateTime;

interface CartInterface
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

    /**
     * Add an item to this cart
     *
     * @param CartItemInterface item
     * @return CartInterface
     */
    public function addItem(CartItemInterface $item);

    /**
     * Remove an item from the cart
     *
     * @param int itemId
     * @return CartInterface
     */
    public function removeItem($itemId);

    /**
     * Set the items in the cart
     *
     * @param array items
     * @return CartInterface
     */
    public function setItems(array $items);

    /**
     * Get all the items in this cart
     *
     * @return array
     */
    public function getItems();
}
