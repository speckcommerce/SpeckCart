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

class Cart implements CartInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /*
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

    /**
     * @ORM\Column(type="integer")
     */
    protected $nextItemId = 1;

    public function addProduct(ProductDescriptorInterface $descriptor, $qty)
    {
        $cartItem = new CartItem($this, $descriptor, $qty);
        // @todo decide if this is good approach vs UUID vs identity generation on persistence
        $cartItem->setId($this->nextItemId++);
        $this->items[$cartItem->getId()] = $cartItem;

        return $cartItem;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getItems()
    {
        return array_values($this->items);
    }

    public function getItem($id)
    {
        if (isset($this->items[$id])) {
            return $this->items[$id];
        }
        return null;
    }

    public function removeItem($itemId)
    {
        unset($this->items[$itemId]);
    }

    public function count()
    {
        return count($this->items);
    }
}
