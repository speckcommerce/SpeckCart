<?php

namespace SpeckCartTest\Service;

use Bootstrap;
use PHPUnit_Framework_TestCase;
use SpeckCart\Entity\CartItem;
use SpeckCart\Service\CartService;
use SpeckCartTest\TestAsset\SessionManager;
use Zend\Session\Container;

require_once 'SpeckCart/TestAsset/SessionManager.php';

class CartServiceTest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->cartService = Bootstrap::getServiceManager()->get('SpeckCart\Service\CartService');
        $this->sessionManager = new SessionManager;

        $this->cartService->setSessionManager($this->sessionManager);
    }

    public function setUp()
    {
        $this->cartService->getCartMapper()->getDbAdapter()->query('TRUNCATE cart', 'execute');
        $this->cartService->getCartMapper()->getDbAdapter()->query('TRUNCATE cart_item', 'execute');
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

    public function testDuplicateItemsAreNotAdded()
    {
        $item = new CartItem;

        $this->cartService->addItemToCart($item);
        $this->cartService->addItemToCart($item);

        $this->assertEquals(1, count($this->cartService->getSessionCart()->getItems()));
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

    public function testUnflatten()
    {
        $items = array(
            new CartItem(array(
                'item_id' => 30,
            )),
            new CartItem(array(
                'item_id' => 1,
            )),
            new CartItem(array(
                'item_id' => 2,
                'parent_item_id' => 1
            )),
            new CartItem(array(
                'item_id' => 3,
                'parent_item_id' => 1
            )),
            new CartItem(array(
                'item_id' => 4,
                'parent_item_id' => 2
            )),
            new CartItem(array(
                'item_id' => 5,
                'parent_item_id' => 30
            ))
        );

        $items = $this->cartService->unflatten($items);

        $children = $items[1]->getChildren();
        $this->assertEquals(2, count($children));
        $this->assertEquals(1, count($children[2]->getChildren()));
        $this->assertEquals(0, count($children[3]->getChildren()));

        $children = $items[30]->getChildren();
        $this->assertEquals(1, count($children));
    }
}
