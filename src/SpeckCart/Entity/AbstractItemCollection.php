<?php
namespace SpeckCart\Entity;

use \Iterator;
use \Countable;

abstract class AbstractItemCollection implements ItemCollectionInterface
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
        $this->items[$item->getCartItemId()] = $item;
        return $this;
    }

    public function addItems(array $items)
    {
        foreach ($items as $i) {
            $this->items[$i->getCartItemid()] = $i;
        }

        return $this;
    }

    public function removeItem($itemOrItemId)
    {
        if ($itemOrItemId instanceof CartItemInterface) {
            $itemOrItemId = $itemOrItemId->getCartItemId();
        }
        if (isset($this->items[$itemOrItemId])) {
            unset($this->items[$itemOrItemId]);
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
        return current($this->items) !== false;
    }
}
