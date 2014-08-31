<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2014 Roave, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace Speckcommerce\Cart\Domain;

use InvalidArgumentException;

class CartItem
{
    protected $cart;
    protected $descriptor;
    protected $qty;

    public function __construct(CartInterface $cart, ProductDescriptorInterface $descriptor, $qty)
    {
        $this->cart = $cart;
        $this->descriptor = $descriptor;
        $this->setQuantity($qty);
    }

    public function getCart()
    {
        return $cart;
    }

    /**
     * getDescriptor
     *
     * @return ProductDescriptorInterface
     */
    public function getDescriptor()
    {
        return $this->descriptor;
    }

    /**
     * setQuantity
     *
     * @param int $qty
     * @throws InvalidArgumentException if quantity is less than 1
     */
    public function setQuantity($qty)
    {
        if (!is_int($qty) || $qty < 1) {
            throw new InvalidArgumentException('Quantity must be positive integer');
        }
        $this->qty = $qty;
    }

    public function getQuantity()
    {
        return $this->qty;
    }

}
