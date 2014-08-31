<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2014 Roave, LLC.
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
     * @return CartItem
     */
    public function addProduct(ProductDescriptorInterface $descriptor, $qty);

    /**
     * Returns items in the cart
     *
     * @return CartItem[]
     */
    public function getItems();
}
