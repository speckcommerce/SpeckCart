<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2015 Roave, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace Speckcommerce\Cart\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Rhumsaa\Uuid\Uuid;
use RuntimeException;

class Cart implements CartInterface
{
    /**
     * id
     *
     * @var string
     */
    protected $id;

    /**
     *
     * @var Collection|CartItemInterface[]
     */
    protected $items;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->items = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function addProduct(ProductDescriptorInterface $descriptor, $qty)
    {
        $cartItem = new CartItem($this, $descriptor, $qty);
        $this->items[$cartItem->getId()] = $cartItem;

        return $cartItem;
    }

    public function getItem($id)
    {
        if (isset($this->items[$id])) {
            return $this->items[$id];
        }
        return null;
    }

    public function getItems()
    {
        return $this->items->toArray();
    }

    public function removeItem($itemOrId)
    {
        if ($itemOrId instanceof CartItemInterface) {
            $itemOrId = $itemOrId->getId();
        }

        return $this->items->remove($itemOrId);
    }

    public function count()
    {
        return count($this->items);
    }

    public function getIterator()
    {
        return $this->items->getIterator();
    }
}
