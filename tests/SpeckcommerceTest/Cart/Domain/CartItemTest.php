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
 * @coversDefaultClass Speckcommerce\Cart\Domain\CartItem
 * @covers ::<!public>
 */
class CartItemTest extends PHPUnit_Framework_TestCase
{
    private $cart;
    private $productDescriptor;

    public function setUp()
    {
        $this->cart = new Cart;
        $this->productDescriptor = new ProductDescriptor;
    }

    /**
     *
     * @covers ::__construct
     * @covers ::getId
     */
    public function testCartItemIdIsGenerated()
    {
        $cartItem = new CartItem($this->cart, $this->productDescriptor, 5);
        $cartItem1 = new CartItem($this->cart, $this->productDescriptor, 5);

        $this->assertNotEmpty($cartItem->getId());
        $this->assertNotEmpty($cartItem1->getId());
        $this->assertNotEquals($cartItem->getId(), $cartItem1->getId());

    }

    /**
     *
     * @covers ::__construct
     * @covers ::getCart
     */
    public function testCreateItemSetsCart()
    {
        $cartItem = new CartItem($this->cart, $this->productDescriptor, 5);
        $this->assertSame($this->cart, $cartItem->getCart());
    }

    /**
     *
     * @covers ::__construct
     * @covers ::getDescriptor
     */
    public function testCreateItemSetsProductDescriptor()
    {
        $cartItem = new CartItem($this->cart, $this->productDescriptor, 5);
        $this->assertSame($this->productDescriptor, $cartItem->getDescriptor());
    }

    /**
     *
     * @covers ::__construct
     * @covers ::getQuantity
     */
    public function testCreateItemWithPositiveQuantity()
    {
        $cartItem = new CartItem($this->cart, $this->productDescriptor, 5);
        $this->assertEquals(5, $cartItem->getQuantity());
    }

    /**
     *
     * @covers ::setQuantity
     * @covers ::getQuantity
     */
    public function testUpdateItemQuantity()
    {
        $cartItem = new CartItem($this->cart, $this->productDescriptor, 5);

        $cartItem->setQuantity(7);
        $this->assertEquals(7, $cartItem->getQuantity());
    }

    /**
     *
     * @covers ::__construct
     */
    public function testCreateItemWithNegativeQtyProducesException()
    {
        $this->setExpectedException('InvalidArgumentException');

        new CartItem($this->cart, $this->productDescriptor, -1);
    }

    /**
     *
     * @covers ::setQuantity
     */
    public function testUpdateWithNegativeQtyProducesException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $cartItem = new CartItem($this->cart, $this->productDescriptor, 5);

        $cartItem->setQuantity(-1);
    }

    /**
     *
     * @covers ::__construct
     */
    public function testCreateItemWithZeroQtyProducesException()
    {
        $this->setExpectedException('InvalidArgumentException');

        new CartItem($this->cart, $this->productDescriptor, 0);
    }

    /**
     *
     * @covers ::setQuantity
     */
    public function testUpdateWithZeroQtyProducesException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $cartItem = new CartItem($this->cart, $this->productDescriptor, 5);

        $cartItem->setQuantity(0);
    }
}

