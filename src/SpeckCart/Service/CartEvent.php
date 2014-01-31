<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\CartItemInterface;

use Zend\EventManager\Event;

class CartEvent extends Event
{
    const EVENT_ADD_ITEM             = 'addItem';
    const EVENT_ADD_ITEM_POST        = 'addItem.post';
    const EVENT_REMOVE_ITEM          = 'removeItem';
    const EVENT_REMOVE_ITEM_POST     = 'removeItem.post';
    const EVENT_CREATE_CART          = 'createCart';
    const EVENT_CREATE_CART_POST     = 'createCart.post';
    const EVENT_DELETE_CART          = 'removeCart';
    const EVENT_DELETE_CART_POST     = 'removeCart.post';
    const EVENT_EMPTY_CART           = 'emptyCart';
    const EVENT_EMPTY_CART_POST      = 'emptyCart.post';
    const EVENT_UPDATE_QUATITY       = 'updateQuantities';
    const EVENT_UPDATE_QUANTITY_POST = 'updateQuantities.post';

    public function setCartItem(CartItemInterface $cartItem)
    {
        $this->setParam('cartitem', $cartItem);
        return $this;
    }

    public function getCartItem()
    {
        return $this->getParam('cartitem');
    }
}
