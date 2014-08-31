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
use DomainException;

class CartItem
{
    protected $cart;
    protected $id;

    protected $descriptor;
    protected $qty;

    public function __construct(CartInterface $cart, ProductDescriptorInterface $descriptor, $qty)
    {
        // @todo consider referencing cart by id and use UUID as cart id
        $this->cart = $cart;
        $this->descriptor = $descriptor;
        $this->setQuantity($qty);
    }

    public function setId($id)
    {
        if (null != $this->id) {
            throw new DomainException('Id was already assigned');
        }
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
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
     * @throws InvalidArgumentException if quantity is not positive integer
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
