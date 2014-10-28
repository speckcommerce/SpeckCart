<?php

namespace SpeckCart\Entity;

use DateTime;

class CartItem extends AbstractItemCollection implements CartItemInterface
{
    protected $cartItemId;
    protected $cartId;
    protected $description = "";
    protected $price;
    protected $quantity;
    protected $addedTime;
    protected $tax = 0;
    protected $parentItemId;
    protected $metadata;

    public function __construct(array $config = array())
    {
        if (count($config)) {
            $this->cartItemId   = isset($config['item_id'])        ? $config['item_id']        : null;
            $this->cartId       = isset($config['cart_id'])        ? $config['cart_id']        : null;
            $this->description  = isset($config['description'])    ? $config['description']    : null;
            $this->price        = isset($config['price'])          ? $config['price']          : null;
            $this->quantity     = isset($config['quantity'])       ? $config['quantity']       : null;
            $this->addedTime    = isset($config['added_time'])     ? $config['added_time']     : null;
            $this->tax          = isset($config['tax'])            ? $config['tax']            : 0;
            $this->parentItemId = isset($config['parent_item_id']) ? $config['parent_item_id'] : 0;
            $this->metadata     = isset($config['metadata'])       ? $config['metadata']       : null;
        }
    }

    public function getCartItemId()
    {
        return $this->cartItemId;
    }

    public function setCartItemId($cartItemId)
    {
        $this->cartItemId = $cartItemId;
        return $this;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice($includeTax=false, $recursive=false)
    {
        $price = $this->price + ($includeTax ? $this->getTax() : 0);

        if ($recursive) {
            foreach ($this->getItems() as $item) {
                $price += $item->getPrice($includeTax, $recursive);
            }
        }
        return $price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity, $recursive = false)
    {
        if ($recursive) {
            foreach($this->getItems() as $child) {
                $child->updateQuantityRecursive($quantity/$this->getQuantity());
            }
        }

        $this->quantity = $quantity;
        return $this;
    }

    public function updateQuantityRecursive($multiplier)
    {
        foreach ($this->getItems() as $child) {
            $child->updatequantityRecursive($multiplier);
        }

        $this->quantity *= $multiplier;
    }

    public function getAddedTime()
    {
        return $this->addedTime;
    }

    public function setAddedTime(DateTime $addedTime)
    {
        $this->addedTime = $addedTime;
        return $this;
    }

    public function getExtPrice($includeTax=true, $recursive=false)
    {
        return $this->getPrice($includeTax, $recursive) * $this->getQuantity();
    }

    public function getExtTax($recursive=false)
    {
        return $this->getTax($recursive) * $this->getQuantity();
    }

    public function getTax($recursive=false)
    {
        $tax = $this->tax;

        if($recursive) {
            foreach($this->getItems() as $item) {
                $tax += $item->getTax($recursive);
            }
        }

        return $tax;
    }

    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    public function getParentItemId()
    {
        return $this->parentItemId;
    }

    public function setParentItemId($itemId)
    {
        $this->parentItemId = $itemId;
        return $this;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function removeItem($item)
    {
        throw new \Exception("not implemented");
    }
}
