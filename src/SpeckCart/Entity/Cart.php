<?php

namespace SpeckCart\Entity;
use \Iterator;
use \Countable;
use \DateTime;

class Cart implements CartInterface, Iterator, Countable
{
    /**
     * @var int
     */
    protected $cartId = 0;

    /**
     * @var DateTime
     */
    protected $createdTime;

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

    public function getCartId()
    {
        return $this->cartId;
    }

    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
        return $this;
    }

    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    public function setCreatedTime(DateTime $time)
    {
        $this->createdTime = $time;
        return $this;
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
        $this->items = array();
        foreach ($items as $i) {
            $this->items[ $i->getCartItemid() ] = $i;
        }

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
        return current($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function next()
    {
        next($this->items);
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function valid()
    {
        return isset($this->current());
    }
}