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
    
    public function addItems(array $items)
    {
        foreach ($items as $i) {
            $this->items[ $i->getCartItemid() ] = $i;
        }

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
        $this->addItems($items);

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
