<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\CartInterface as Cart,
    SpeckCart\Entity\CartItemInterface as CartItem;

interface CartServiceInterface
{
    public function addItemToCart(Cart $cart, CartItem $item);

    public function removeItemFromCart(Cart $cart, $itemId);
}
