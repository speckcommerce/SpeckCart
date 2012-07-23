<?php

namespace SpeckCart\Entity;
use \Iterator;
use \Countable;

class Cart implements CartInterface, Iterator, Countable
{
    /**
     * @var array
     */
    protected $items = array();
    
    /**
     * index for looping
     * 
     * @var int
     */
    protected $itemIndex = 0;

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

    public function count()
    {
        return count($this->items);
    }

    public function current()
    {
        return $this->items[$this->itemIndex];
    }

    public function key()
    {
        return $this->itemIndex;
    }

    public function next()
    {
        $this->itemIndex++;
    }

    public function rewind()
    {
        $this->itemIndex = 0;
    }

    public function valid()
    {
        return isset($this->items[$this->itemIndex]);;
    }
}
