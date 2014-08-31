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

class Cart implements CartInterface
{
    protected $items = array();

    public function addProduct(ProductDescriptorInterface $descriptor, $qty)
    {
        if (!is_int($qty) || $qty < 1) {
            throw new InvalidArgumentException('Quantity must be positive integer');
        }
        $cartItem = new CartItem($this, $descriptor, $qty);
        $this->items[] = $cartItem;

        return $cartItem;
    }

    public function count()
    {
        return count($this->items);
    }

    public function getItems()
    {
        return $this->items;
    }
}
