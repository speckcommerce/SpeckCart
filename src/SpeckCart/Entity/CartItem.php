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
    
}
