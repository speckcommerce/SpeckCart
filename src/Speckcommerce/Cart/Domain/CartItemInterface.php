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

interface CartItemInterface
{
    /**
     *
     * @param CartInterface $cart Cart holding this item
     * @param ProductDescriptorInterface $descriptor
     * @param int $qty
     */
    public function __construct(CartInterface $cart, ProductDescriptorInterface $descriptor, $qty);

    /**
     *
     * @return CartInterface
     */
    public function getCart();

    /**
     *
     * @return ProductDescriptorInterface
     */
    public function getDescriptor();

    /**
     * Set quantity
     *
     * @param int $qty
     * @throws InvalidArgumentException if quantity is not positive integer
     */
    public function setQuantity($qty);

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity();
}
