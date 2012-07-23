<?php

namespace SpeckCart\Mapper;

use SpeckCart\Entity\Cart;
use SpeckCart\Entity\CartInterface;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class CartMapperZendDb extends AbstractDbMapper
{
    protected $tableName = 'cart';
    protected $cartIdField = 'cart_id';

    public function __construct()
    {
        $this->setEntityPrototype(new Cart);
        $this->setHydrator(new ClassMethods(true));
    }

    public function findById($cartId)
    {
        $select = new Select;
        $select->from($this->tableName);

        $where = new Where;
        $where->equalTo($this->cartIdField, $cartId);

        $resultSet = $this->selectWith($select->where($where));
        return $resultSet->current();
    }

    public function persist(CartInterface $cart)
    {
        if ($cart->getCartId() > 0) {
            $where = new Where;
            $where->equalTo($this->cartIdField, $cartId);

            $this->update($cart, $where, $this->tableName);
        } else {
            $this->insert($cart, $this->tableName);
        }
    }
}
