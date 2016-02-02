<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\CartItem;

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
            if(!$object) {
                $cloneObject = new CartItem;
            } else {
                $cloneObject = clone $object;
            }

            $item = $this->hydrateSingle($row, $cloneObject);

            if (!$item->getParentItemId()) {
                $result[] = $item;
            }
        }

        return $result;
    }

    protected function hydrateSingle(array $data, $object)
    {
        $cloneObject = clone $object;

        if (isset($this->index[ $data['item_id'] ])) {
            $this->index[ $data['item_id'] ]['hydrated'] = true;
            return $this->index[ $data['item_id'] ]['object'];
        }

        if (isset($this->index[ $data['item_id'] ])) {
            $cloneObject = $this->index[ $data['item_id'] ]['object'];
        }

        $item = parent::hydrate($data, $cloneObject);

        $this->index[ $data['item_id'] ] = array(
            'object'    => $item,
            'hydrated'  => true
        );

        if ($data['parent_item_id']) {
            $parent = $this->getParent($data['parent_item_id'], $object);
            $item->setParent($parent);
            $parent->addItem($item);
        }

        return $item;
    }

    protected function getParent($id, $object=null)
    {
        if (isset($this->index[$id]) && $this->index[$id]['object'] !== null) {
            return $this->index[$id]['object'];
        } else {
            return $this->addPrototype($id, $object);
        }
    }

    protected function addPrototype($id, $object=null)
    {
        if(isset($object)) {
            $cloneObject = clone $object;
        } else {
            $cloneObject = new CartItem;
        }

        $cloneObject->setCartItemId($id);
        $this->index[$id] = array(
            'object' => $cloneObject,
            'hydrated' => false
        );

        return $cloneObject;
    }
}
