<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2015 Roave, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace Speckcommerce\Cart\Domain;

use DomainException;
use InvalidArgumentException;
use Rhumsaa\Uuid\Uuid;

class CartItem
{
    /**
     *
     * @var CartInterface
     */
    protected $cart;

    /**
     * id
     *
     * @var string
     */
    protected $id;

    /**
     *
     * @var ProductDescriptorInterface
     */
    protected $descriptor;

    /**
     *
     * @var integer
     */
    protected $qty;

    public function __construct(CartInterface $cart, ProductDescriptorInterface $descriptor, $qty)
    {
        // Id can be generated inside cart and be unique across it.
        // @todo I shall revisit current approach when i will have chance
        // to benchmark both approaches in production scale scenarios.
        $this->id = Uuid::uuid4()->toString();
        $this->cart = $cart;
        $this->descriptor = $descriptor;
        $this->setQuantity($qty);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCart()
    {
        return $this->cart;
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
     * Set quantity
     *
     * @internal Use Cart to modify item quantity.
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
