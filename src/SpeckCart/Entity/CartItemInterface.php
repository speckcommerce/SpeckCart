<?php

namespace SpeckCart\Entity;

use DateTime;

interface CartItemInterface extends ItemCollectionInterface
{
    /**
     * Get the ID for this cart item
     *
     * @return int
     */
    public function getCartItemId();

    /**
     * Set the ID for this cart item
     *
     * @param int cartItemId
     * @return CartItemInterface
     */
    public function setCartItemId($cartItemId);

    /**
     * Get the cart ID this item belongs to
     *
     * @return int
     */
    public function getCartId();

    /**
     * Set the cart ID this item belongs to
     *
     * @param int cartId
     * @return CartItemInterface
     */
    public function setCartId($cartId);

    /**
     * Get the price of this item
     *
     * @return float
     */
    public function getPrice();

    /**
     * Set the price of this item
     *
     * @param float price
     * @return CartItemInterface
     */
    public function setPrice($price);

    /**
     * Get the number of items in the cart
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Set the number of items in the cart
     *
     * @param int quantity
     * @return CartItemInterface
     */
    public function setQuantity($quantity);

    /**
     * Get the DateTime that this item was added to the cart
     *
     * @return DateTime
     */
    public function getAddedTime();

    /**
     * Set the DateTime that this item was added to the cart
     *
     * @param DateTime added time
     * @return CartItemInterface
     */
    public function setAddedTime(DateTime $time);

    /**
     * Get the extended price for this item (and children if selected)
     *
     * @param Boolean include tax
     * @param Boolean recursive
     * @return float
     */
    public function getExtPrice($includeTax=true, $recursive=false);

    /**
     * Get the extended tax price for this item (and children if selected)
     *
     * @param Boolean recursive
     * @return float
     */
    public function getExtTax($recursive=false);

    /**
    * Get the tax associated for this item
    *
    * @return float
    */
    public function getTax();

    /**
    * set the tax for this item
    *
    * @param float $tax Tax Value
    * @return CartItemInterface
    **/
    public function setTax($tax);
}
