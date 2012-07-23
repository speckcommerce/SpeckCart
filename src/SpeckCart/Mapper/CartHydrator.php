<?php

namespace SpeckCart\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class CartHydrator implements HydratorInterface
{
    public function extract($object)
    {
        return array(
            'cart_id' => $object->getCartId(),
            'created_time' => $object->getCreatedTime()->format('c')
        );
    }

    public function hydrate(array $data, $object)
    {
        $object->setCartId($data['cart_id'])
            ->setCreatedTime(new \DateTime($data['created_time']));

        return $object;
    }
}
