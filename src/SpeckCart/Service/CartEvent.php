<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\CartItemInterface;

use Zend\EventManager\Event;

class CartEvent extends Event
{
    const EVENT_ADD_ITEM         = 'addItem';
    const EVENT_ADD_ITEM_POST    = 'addItem.post';
    const EVENT_REMOVE_ITEM      = 'removeItem';
    const EVENT_REMOVE_ITEM_POST = 'removeItem.post';

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
