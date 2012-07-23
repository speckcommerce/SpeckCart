<?php

namespace SpeckCart\Entity;

class Cart implements CartInterface
{
    /**
     * @var array
     */
    protected $items = array();

    /**
     * constructor
     *
     * @param array items already in cart
     */
    public function __construct(array $items = array())
    {
        $this->setItems($items);
    }

    public function addItem(CartItemInterface $item)
    {
        $this->items[ $item->getCartItemId() ] = $item;
        return $this;
    }

    public function removeItem($itemId)
    {
        if (isset($this->items[$itemId])) {
            unset($this->items[$itemId]);
        }

        return $this;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }
}
