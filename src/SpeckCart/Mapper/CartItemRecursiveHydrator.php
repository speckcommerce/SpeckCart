<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\CartItem;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CartItemRecursiveHydrator extends CartItemHydrator
{
    protected $index;

    public function extract($object)
    {
    }

    public function hydrate(array $data, $object)
    {
        $this->index = array();
        $result = array();

        foreach ($data as $row) {
            $item = $this->hydrateSingle($row, new CartItem);

            if (!$item->getParentItemId()) {
                $result[] = $item;
            }
        }

        return $result;
    }

    protected function hydrateSingle(array $data, $object)
    {
        if (isset($this->index[ $data['item_id'] ])) {
            $this->index[ $data['item_id'] ]['hydrated'] = true;
            return $this->index[ $data['item_id'] ]['object'];
        }

        $item = parent::hydrate($data, $object);

        $this->index[ $data['item_id'] ] = array(
            'object'    => $item,
            'hydrated'  => true
        );

        if ($data['parent_item_id']) {
            $parent = $this->getParent($data['parent_item_id']);
            $item->setParent($parent);
            $parent->addItem($item);
        }

        return $item;
    }

    protected function getParent($id)
    {
        if (isset($this->index[$id])) {
            return $this->index[$id];
        } else {
            return $this->addPrototype($id);
        }
    }

    protected function addPrototype($id)
    {
        $object = new CartItem;
        $object->setCartItemId($id);

        $this->index[$id] = array(
            'object' => $object,
            'hydrated' => false
        );

        return $object;
    }
}
