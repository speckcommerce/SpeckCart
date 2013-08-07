<?php

namespace SpeckCartTest\Entity;

use SpeckCartTest\Bootstrap;
use PHPUnit_Framework_TestCase;

use SpeckCart\Entity\CartItem;
use SpeckCart\Service\CartEvent;
use SpeckCartTest\TestAsset\SessionManager;
use SpeckCartTest\Mapper\TestAsset\AbstractTestCase;


require_once 'SpeckCartTest/TestAsset/SessionManager.php';

class CartServiceTest extends AbstractTestCase
{
    public function testUpdateQuantities()
    {
        $item = new CartItem;
        $item->setQuantity(1);
        $item->setCartItemId(1);

        $this->assertEquals(1, $item->getQuantity());

        $item->setQuantity(4);
        $this->assertEquals(4, $item->getQuantity());
    }

    public function testUpdateQuantitiesWithChildren()
    {
        // Create a nested cart item structure
        $item = new CartItem;
        $item->setQuantity(1);
        $item->setCartItemId(1);

        $item1 = new CartItem;
        $item1->setQuantity(2);
        $item1->setCartItemId(2);
        $item1->setParentItemId(1);

        $item2 = new CartItem;
        $item2->setQuantity(3);
        $item2->setCartItemId(3);
        $item2->setParentItemId(2);

        $item1->addItem($item2);
        $item->addItem($item1);

        // Check the initial state of the quantities
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(2, $item->getItems()[2]->getQuantity());
        $this->assertEquals(3, $item->getItems()[2]->getItems()[3]->getQuantity());

        // Double the quantity of all items
        $item->setQuantity(2, true);
        $this->assertEquals(2, $item->getQuantity());
        $this->assertEquals(4, $item->getItems()[2]->getQuantity());
        $this->assertEquals(6, $item->getItems()[2]->getItems()[3]->getQuantity());

        // Update again to check the multiplier works
        $item->setQuantity(3, true);
        $this->assertEquals(3, $item->getQuantity());
        $this->assertEquals(6, $item->getItems()[2]->getQuantity());
        $this->assertEquals(9, $item->getItems()[2]->getItems()[3]->getQuantity());

        // Reduce quantities of items
        $item->setQuantity(1, true);
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(2, $item->getItems()[2]->getQuantity());
        $this->assertEquals(3, $item->getItems()[2]->getItems()[3]->getQuantity());

        // Update an individual item without affecting any others...
        $item->getItems()[2]->setQuantity(4);
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(4, $item->getItems()[2]->getQuantity());
        $this->assertEquals(3, $item->getItems()[2]->getItems()[3]->getQuantity());
    }
}
