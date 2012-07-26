<?php
namespace SpeckCart\Entity;

use \Iterator;
use \Countable;

interface ItemCollectionInterface extends Iterator, Countable
{
    public function addItem(CartItemInterface $item);

    public function addItems(array $items);

    public function removeItem($itemOrItemId);

    public function setItems(array $items);

    public function getItems();
}
