<?php

namespace SpeckCartTest\Service;

use PHPUnit_Framework_TestCase;
use SpeckCart\Entity\CartItem;
use SpeckCart\Service\CartService;
use SpeckCartTest\TestAsset\SessionManager;

require_once 'SpeckCart/TestAsset/SessionManager.php';

class CartServiceTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->cartService = new CartService;
        $this->sessionManager = new SessionManager;

        $this->cartService->setSessionManager($this->sessionManager);
    }

    public function testInitialCartIsEmpty()
    {
        $this->assertEquals(0, count($this->cartService->getSessionCart()->getItems()));
        $this->assertInstanceOf('SpeckCart\Entity\Cart', $this->cartService->getSessionCart());
    }

    public function testAddToCart()
    {
        $item = new CartItem;
        $item->setCartItemId(1);

        $return = $this->cartService->addItemToCart($item);

        // check fluent interface
        $this->assertSame($return, $this->cartService);

        // check the item was added
        $this->assertEquals(1, count($this->cartService->getSessionCart()->getItems()));

        // check that it's the same item still
        $itemAddedToCart = $this->cartService->getSessionCart()->getItems();
        $this->assertSame($item, $itemAddedToCart[1]);
    }

    public function testDuplicateItemsAreNotAdded()
    {
        $item = new CartItem;
        $item->setCartItemId(2);

        $this->cartService->addItemToCart($item);
        $this->cartService->addItemToCart($item);

        $this->assertEquals(1, count($this->cartService->getSessionCart()->getItems()));
    }

    public function testRemoveFromCart()
    {
        $item = new CartItem;
        $item->setCartItemId(1);

        $return = $this->cartService->addItemToCart($item);

        // ensure it was added first
        $this->assertEquals(1, count($this->cartService->getSessionCart()->getItems()));

        $this->cartService->removeItemFromCart(1);

        // ensure it was removed
        $this->assertEquals(0, count($this->cartService->getSessionCart()->getItems()));
    }
}
