<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\CartItemInterface;

interface CartItemMapperInterface
{
    public function findById($cartItemId);

    public function findByCartId($cartId);

    public function deleteById($cartItemId);

    public function persist(CartItemInterface $item);
}
