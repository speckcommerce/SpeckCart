<?php

namespace SpeckCart\Entity;

use DateTime;

class CartItem implements CartItemInterface
{
    protected $cartItemId;
    protected $cartId;
    protected $performanceIndicators;
    protected $price;
    protected $quantity;
    protected $addedTime;
    protected $tax = 0;
    protected $parentItemId = 0;

    protected $children = array();

    public function __construct(array $config = array())
    {
        if (count($array)) {
            $this->cartItemId   = !isset($config['item_id'])        ?: $config['item_id'];
            $this->cartId       = !isset($config['cart_id'])        ?: $config['cart_id'];
            $this->price        = !isset($config['price'])          ?: $config['price'];
            $this->quantity     = !isset($config['quantity'])       ?: $config['quantity'];
            $this->addedTime    = !isset($config['added_time'])     ?: $config['added_time'];
            $this->tax          = !isset($config['tax'])            ?: $config['tax'];
            $this->parentItemId = !isset($config['parent_item_id']) ?: $config['parent_item_id'];
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

    public function getPerformanceIndicators()
    {
        return $this->performanceIndicators;
    }

    public function setPerformanceIndicators(array $performanceIndicators)
    {
        $this->performanceIndicators = $performanceIndicators;
        return $this;
    }

    public function addPerformanceIndicator($indicator)
    {
        $this->performanceIndicators[] = $indicator;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
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

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
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

    public function getExtPrice()
    {
        return ($this->getPrice() + $this->getTax()) * $this->getQuantity();
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

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
        return $this;
    }

    public function addChild(CartItemInterface $child)
    {
        $this->children[ $child->getCartItemId() ] = $child;
        return $this;
    }
}
