<?php

namespace SpeckCart\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class CartItemHydrator implements HydratorInterface
{
    public function extract($object)
    {
        $result = array(
            'cart_id'                => $object->getCartId(),
            'description'            => $object->getDescription(),
            'price'                  => $object->getPrice() ?: 0.00,
            'quantity'               => $object->getQuantity() ?: 0,
            'tax'                    => $object->getTax() ?: 0,
            'added_time'             => $object->getAddedTime()->format('c'),
            'parent_item_id'         => $object->getParentItemId(),
            'metadata'               => serialize($object->getMetadata()),
        );

        if ($object->getCartItemId() !== null) {
            $result['item_id'] = $object->getCartItemId();
        }

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        $object->setCartItemId($data['item_id'])
            ->setCartId($data['cart_id'])
            ->setDescription($data['description'])
            ->setPrice($data['price'])
            ->setQuantity($data['quantity'])
            ->setTax($data['tax'])
            ->setAddedTime(new \DateTime($data['added_time']))
            ->setParentItemId($data['parent_item_id'])
            ->setMetadata(unserialize($data['metadata']));

        return $object;
    }
}

