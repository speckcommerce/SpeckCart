<?php

namespace SpeckCart\Service;

use SpeckCart\Entity\Cart;
use SpeckCart\Entity\CartInterface;
use SpeckCart\Entity\CartItemInterface;

use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Session\Container;

class CartService implements CartServiceInterface, EventManagerAwareInterface
{
    protected $sessionManager;
    protected $cartMapper;
    protected $itemMapper;
    protected $eventManager;

    protected $index;

    public function __construct()
    {
        $this->setEventManager(new EventManager());
    }

    public function createSessionCart()
    {
        $container = new Container('speckcart', $this->getSessionManager());

        $cart = new Cart;
        $cart->setCreatedTime(new \DateTime());

        $cart = $this->cartMapper->persist($cart);
        $container->cartId = $cart->getCartId();
        return $cart;
    }

    public function getSessionCart($create = false)
    {
        $container = new Container('speckcart', $this->getSessionManager());

        if (!isset($container->cartId)) {
            if ($create) {
                $cart = $this->createSessionCart();
            } else {
                $cart = new Cart;
                $cart->setCreatedTime(new \DateTime());
            }
        } else {
            $cart = $this->cartMapper->findById($container->cartId);
            $items = $this->itemMapper->findByCartId($cart->getCartId());

            $cart->setItems($items);
        }

        return $cart;
    }

    public function findById($cartId)
    {
        return $this->cartMapper->findById($cartId);
    }

    public function findItemById($itemId)
    {
        return $this->itemMapper->findById($itemId);
    }

    public function persist(CartItemInterface $item)
    {
        return $this->cartMapper->persist($item);
    }

    public function onAddItem(Event $e)
    {
        $this->addItemToCart($e->getCartItem());
        $this->getEventManager()->trigger(CartEvent::EVENT_ADD_ITEM_POST, $this, $e->getParams());
    }

    public function addItemToCart(CartItemInterface $item, CartInterface $cart = null)
    {
        if ($cart === null) {
            $cart = $this->getSessionCart(true);
        }

        $item->setCartId($cart->getCartId())
            ->setAddedTime(new \DateTime());
        $this->itemMapper->persist($item);

        $this->persistCartItemChildren($item->getItems(), $item, $cart);

        $cart->addItem($item);

        return $this;
    }

    protected function persistCartItemChildren(array $children, CartItemInterface $parent, CartInterface $cart)
    {
        foreach ($children as $i) {
            $i->setCartId($cart->getCartId())
                ->setAddedTime(new \DateTime())
                ->setParentItemId($parent->getCartItemId())
                ->setParent($parent);

            $this->itemMapper->persist($i);
            $this->persistCartItemChildren($i->getItems(), $i, $cart);
        }
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

    public function attachDefaultListeners()
    {
        $events = $this->getEventManager();
        $events->attach(CartEvent::EVENT_ADD_ITEM, array($this, 'onAddItem'));
        //$events->attach(CartEvent::EVENT_REMOVE_ITEM, array($this, 'onRemoveItem'));
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

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(
            __CLASS__,
            get_called_class(),
            'speckcart'
        );

        $eventManager->setEventClass('SpeckCart\Service\CartEvent');

        $this->eventManager = $eventManager;
        return $this;
    }
}
