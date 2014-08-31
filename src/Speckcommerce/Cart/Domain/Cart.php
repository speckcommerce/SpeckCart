<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2014 Roave, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace Speckcommerce\Cart\Domain;

use Speckcommerce\Cart\Domain\Specification\AcceptableItemQuantity;
use RuntimeException;
use Rhumsaa\Uuid\Uuid;

class Cart implements CartInterface
{
    /**
     *
     * @ORM\Column(type="uuid")
     * @ORM\Id
     */
    protected $id;

    /**
     * Optimistic concurrency lock
     * @ORM\Column(type="integer") @Version
     */
    protected $version;

    /**
     * @ORM\OneToMany(
     *   targetEntity="CartItem",
     *   mappedBy="???",
     *   orphanRemoval=true,
     *   cascade={"persist", "remove", "merge"}
     * )
     */
    protected $items = array();

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getId()
    {
        return new CartId($this->id);
    }

    public function addProduct(ProductDescriptorInterface $descriptor, $qty)
    {
        $cartItem = new CartItem($this, $descriptor, $qty);
        $this->items[(string)$cartItem->getId()] = $cartItem;

        return $cartItem;
    }

    public function getItem(CartItemId $id)
    {
        $id = (string) $id;
        if (isset($this->items[$id])) {
            return $this->items[$id];
        }
        return null;
    }

    public function getItems()
    {
        return array_values($this->items);
    }

    public function removeItem(CartItemId $id)
    {
        $id = (string) $id;
        unset($this->items[$id]);
    }

    public function count()
    {
        return count($this->items);
    }
}
