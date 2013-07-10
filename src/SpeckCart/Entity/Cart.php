<?php

namespace SpeckCart\Entity;
use \Iterator;
use \Countable;
use \DateTime;

class Cart extends AbstractItemCollection implements CartInterface
{
    /**
     * @var int
     */
    protected $cartId = 0;

    /**
     * @var DateTime
     */
    protected $createdTime;

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

    public function getTotal($includeTax=true, $recursive=true)
    {
        $total = 0;
        foreach($this->getItems() as $item)
        {
            $total += $item->getExtPrice($includeTax, $recursive);
        }

        return $total;
    }

    public function getTaxTotal($recursive=true)
    {
        $total = 0;
        foreach($this->getItems() as $item)
        {
            $total += $item->getExtTax($recursive);
        }

        return $total;
    }
}
