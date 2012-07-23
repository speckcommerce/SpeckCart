<?php

namespace SpeckCart\Entity;

interface CartInterface
{
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
