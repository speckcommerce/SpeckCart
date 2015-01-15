<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2015 Roave, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace SpeckcommerceTest\Cart\Domain;

use PHPUnit_Framework_TestCase;
use Speckcommerce\Cart\Domain\Cart;
use Speckcommerce\Cart\Domain\ProductDescriptor;
use Speckcommerce\Cart\Domain\CartItem;
use Money\Money;

/**
 *
 * @coversDefaultClass Speckcommerce\Cart\Domain\Cart
 * @covers ::<!public>
 */
class CartTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $unitPrice = Money::USD(100);
        $this->descriptor = new ProductDescriptor('ProductName', $unitPrice);
    }

    public function testNewCartIsEmpty()
    {
        $cart = new Cart();
        $this->assertCount(0, $cart);
        $this->assertEquals([], $cart->getItems());
    }

    /**
     *
     * @covers ::addProduct
     */
    public function testAddProductToCartReturnsItem()
    {
        $cart = new Cart();
        $cartItem = $cart->addProduct($this->descriptor, 1);

        $this->assertInstanceOf(CartItem::class, $cartItem);
    }

    /**
     *
     * @covers ::addProduct
     */
    public function testAddProductToCartActuallyAddsItem()
    {
        $cart = new Cart();
        $cartItem = $cart->addProduct($this->descriptor, 2);

        $this->assertEquals(1, count($cart));
        $this->assertEquals([$cartItem], $cart->getItems());
    }

    /**
     *
     * @covers ::addProduct
     */
    public function testAddProductWithSameDescriptorUsedTwiceCreatesTwoItems()
    {
        $cart = new Cart();
        $cartItem1 = $cart->addProduct($this->descriptor, 2);
        $cartItem2 = $cart->addProduct($this->descriptor, 2);

        $this->assertCount(2, $cart);
        $this->assertNotSame($cartItem1, $cartItem2);
        $this->assertEquals([$cartItem1, $cartItem2], $cart->getItems());
    }

    public function testAddProductPassesDescriptorToItem()
    {
        $cart = new Cart();
        $cartItem = $cart->addProduct($this->descriptor, 5);

        $this->assertEquals($this->descriptor, $cartItem->getDescriptor());
    }

    public function testAddProductPassesQtyToItem()
    {
        $cart = new Cart();
        $cartItem = $cart->addProduct($this->descriptor, 5);

        $this->assertEquals(5, $cartItem->getQuantity());
    }

    public function testRemoveItem()
    {
        $cart = new Cart();
        $cartItem1 = $cart->addProduct($this->descriptor, 1);
        $cartItem2 = $cart->addProduct($this->descriptor, 1);

        $cart->removeItem($cartItem1->getId());

        $this->assertCount(1, $cart);
        $this->assertNull($cart->getItem($cartItem1->getId()));
        $this->assertSame($cartItem2, $cart->getItem($cartItem2->getId()));
    }
}
