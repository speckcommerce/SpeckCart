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

    public function getPrice($recursive = false)
    {
        if (false === $recursive) {
            return $this->price;
        }

        $price = $this->price;
        if (count($this->getItems()) > 0) {
            foreach ($this->getItems() as $item) {
                $price = $price + $item->getPrice(true);
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
        $price = 0;
        if($includeTax) {
            $price = ($this->getPrice() + $this->getTax()) * $this->getQuantity();
        } else {
            $price = $this->getPrice() * $this->getQuantity();
        }

        if($recursive) {
            foreach($this->getItems() as $item) {
                $price += $item->getExtPrice($includeTax, $recursive);
            }
        }

        return $price;
    }

    public function getExtTax($recursive=false)
    {
        $price = $this->getTax() * $this->getQuantity();

        if($recursive) {
            foreach($this->getItems() as $item) {
                $price += $item->getExtTax($recursive);
            }
        }

        return $price;
    }

    public function getTax()
    {
        return $this->tax;
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
