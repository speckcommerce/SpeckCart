<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2015 Roave, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace Speckcommerce\Cart\Domain;

use Countable;

interface CartInterface extends Countable
{
    /**
     * Adds product to cart
     *
     * @param ProductDescriptor $descriptor
     * @param int $qty
     * @return CartItemInterface
     */
    public function addProduct(ProductDescriptorInterface $descriptor, $qty);

    /**
     * Returns items in the cart
     *
     * @return CartItemInterface[]
     */
    public function getItems();
}
