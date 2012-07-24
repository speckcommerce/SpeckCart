<?php

namespace SpeckCart\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class CartItemHydrator implements HydratorInterface
{
    /**
     * @TODO performance indicators
     */
    public function extract($object)
    {
        $result = array(
            'cart_id'                => $object->getCartId(),
            'price'                  => $object->getPrice() ?: 0.00,
            'quantity'               => $object->getQuantity() ?: 0,
            'tax'                    => $object->getTax() ?: 0,
            'added_time'             => $object->getAddedTime()->format('c'),
            'parent_item_id'         => $object->getParentItemId(),
        );

        if ($object->getCartItemId() !== null) {
            $result['item_id'] = $object->getCartItemId();
        }

        return $result;
    }

    /**
     * @TODO performance indicators
     */
    public function hydrate(array $data, $object)
    {
        $object->setCartItemId($data['item_id'])
            ->setCartId($data['cart_id'])
            ->setPrice($data['price'])
            ->setQuantity($data['quantity'])
            ->setTax($data['tax'])
            ->setAddedTime(new \DateTime($data['added_time']))
            ->setParentItemId($data['parent_item_id']);

        return $object;
    }
}

