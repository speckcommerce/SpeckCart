<?php

namespace SpeckCartTest\Service;

use SpeckCartTest\Bootstrap;
use PHPUnit_Framework_TestCase;

use SpeckCart\Entity\CartItem;
use SpeckCart\Service\CartEvent;
use SpeckCart\Service\CartService;
use SpeckCartTest\TestAsset\SessionManager;
use SpeckCartTest\Mapper\TestAsset\AbstractTestCase;

use Zend\Session\Container;

require_once 'SpeckCartTest/TestAsset/SessionManager.php';

class CartServiceTest extends AbstractTestCase
{
    public function __construct()
    {
        $this->cartService = Bootstrap::getServiceManager()->get('SpeckCart\Service\CartService');
        $this->sessionManager = new SessionManager;

        $this->cartService->setSessionManager($this->sessionManager);
    }

    public function setUp()
    {
        parent::setup();
        $container = new Container('speckcart', $this->sessionManager);
        unset($container->cartId);
    }

    public function testInitialCartIsEmpty()
    {
        $this->assertEquals(0, count($this->cartService->getSessionCart()->getItems()));
        $this->assertInstanceOf('SpeckCart\Entity\Cart', $this->cartService->getSessionCart());
    }

    public function testAddToCart()
    {
        $item = new CartItem;
        $return = $this->cartService->addItemToCart($item);

        // check fluent interface
        $this->assertSame($return, $this->cartService);

        // check the item was added
        $this->assertEquals(1, count($this->cartService->getSessionCart()->getItems()));

        // check that it's the same item still
        $itemAddedToCart = $this->cartService->getSessionCart()->getItems();
        $this->assertEquals($item->getCartItemId(), $itemAddedToCart[1]->getCartItemId());
    }

    public function testAddUsingEvent()
    {
        $event = new CartEvent;
        $event->setCartItem(new CartItem);

        $this->cartService->onAddItem($event);
        $itemAddedToCart = $this->cartService->getSessionCart()->getItems();
        $this->assertEquals(1, $itemAddedToCart[1]->getCartItemId());
    }

    public function testDuplicateItemsAreNotAdded()
    {
        $item = new CartItem;

        $this->cartService->addItemToCart($item);
        $this->cartService->addItemToCart($item);

        $this->assertEquals(1, count($this->cartService->getSessionCart()->getItems()));
    }

    public function testRecursiveItems()
    {
        $item = new CartItem;
        $item->setDescription("parent");

        $child = new CartItem;
        $child->setDescription("child");

        $item->addItem($child);

        $this->cartService->addItemToCart($item);
        $items = $this->cartService->getSessionCart()->getItems();

        $parent = $items[1];
        $this->assertEquals("parent", $parent->getDescription());

        $children = $parent->getItems();
        $this->assertEquals(1, count($parent->getItems()));

        $child = $children[2];
        $this->assertEquals("child", $child->getDescription());
    }

    public function testRemoveFromCart()
    {
        $item = new CartItem;

        $return = $this->cartService->addItemToCart($item);

        // ensure it was added first
        $this->assertEquals(1, count($this->cartService->getSessionCart()->getItems()));

        $this->cartService->removeItemFromCart(1);

        // ensure it was removed
        $this->assertEquals(0, count($this->cartService->getSessionCart()->getItems()));
    }

    public function testEmptyCart()
    {
        $item = new CartItem;
        $item1 = new CartItem;

        $this->cartService->addItemToCart($item);
        $this->cartService->addItemToCart($item1);

        // ensure multiple items exist first
        $this->assertEquals(2, count($this->cartService->getSessionCart()->getItems()));

        $this->cartService->emptyCart();

        // ensure all items were removed
        $this->assertEquals(0, count($this->cartService->getSessionCart()->getItems()));
    }
}
