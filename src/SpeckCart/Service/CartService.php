<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\Cart;
use SpeckCart\Entity\CartInterface;
use SpeckCart\Entity\CartItemInterface;

use Zend\Session\Container;

class CartService implements CartServiceInterface
{
    public function getSessionCart()
    {
        $container = new Container('speckcart');

        if (!isset($container->cart)) {
            $container->cart = new Cart;
        }

        return $container->cart;
    }

    public function addItemToCart(CartItemInterface $item, CartInterface $cart = null)
    {
        if ($cart === null) {
            $cart = $this->getSessionCart();
        }

        return $this;
    }

    public function removeItemFromCart($itemId, CartInterface $cart = null)
    {
        if ($cart === null) {
            $cart = $this->getSessionCart();
        }

        return $this;
    }
}
