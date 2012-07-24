<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\Cart;
use SpeckCart\Entity\CartInterface;
use SpeckCart\Entity\CartItemInterface;

use Zend\Session\Container;

class CartService implements CartServiceInterface
{
    protected $sessionManager;
    protected $cartMapper;
    protected $itemMapper;

    public function getSessionCart()
    {
        $container = new Container('speckcart', $this->getSessionManager());

        if (!isset($container->cartId)) {
            $cart = new Cart;
            $cart->setCreatedTime(new \DateTime());

            $cart = $this->cartMapper->persist($cart);
            $container->cartId = $cart->getCartId();
        } else {
            $cart = $this->cartMapper->findById($container->cartId);
        }

        $items = $this->itemMapper->findByCartId($cart->getCartId());
        $items = $this->unflatten($items);

        $cart->setItems($items);
        return $cart;
    }

    public function unflatten(array $items) {
        $tree = array();
        foreach ($items as $i) {
            $tree[ $i->getCartItemId() ] = $i;

            if ($i->getParentItemId() != 0) {
                $tree[ $i->getParentItemId() ]->addChild($i);
            }
        }

        foreach ($tree as $index => $item) {
            if ($item->getParentItemId() != 0) {
                unset($tree[$index]);
            }
        }

        return $tree;
    }

    public function addItemToCart(CartItemInterface $item, CartInterface $cart = null)
    {
        if ($cart === null) {
            $cart = $this->getSessionCart();
        }

        $item->setCartId($cart->getCartId())
            ->setAddedTime(new \DateTime());
        $this->itemMapper->persist($item);

        $cart->addItem($item);

        return $this;
    }

    public function removeItemFromCart($itemId, CartInterface $cart = null)
    {
        if ($cart === null) {
            $cart = $this->getSessionCart();
        }

        $this->itemMapper->deleteById($itemId);
        $cart->removeItem($itemId);

        return $this;
    }

    public function getSessionManager()
    {
        if ($this->sessionManager === null) {
            $this->sessionManager = Container::getDefaultManager();
        }

        return $this->sessionManager;
    }

    public function setSessionManager($sessionManager)
    {
        $this->sessionManager = $sessionManager;
        return $this;
    }

    public function getCartMapper()
    {
        return $this->cartMapper;
    }

    public function setCartMapper($cartMapper)
    {
        $this->cartMapper = $cartMapper;
        return $this;
    }

    public function getItemMapper()
    {
        return $this->itemMapper;
    }

    public function setItemMapper($itemMapper)
    {
        $this->itemMapper = $itemMapper;
        return $this;
    }
}
