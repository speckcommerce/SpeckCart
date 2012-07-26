<?php

namespace SpeckCart\Mapper;

use ArrayObject;

use SpeckCart\Entity\CartItem;
use SpeckCart\Entity\CartItemInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ArraySerializable;

use ZfcBase\Mapper\AbstractDbMapper;

class CartItemMapperZendDb extends AbstractDbMapper implements CartItemMapperInterface
{
    protected $tableName = 'cart_item';
    protected $itemIdField = 'item_id';

    public function __construct()
    {
        $this->setEntityPrototype(new CartItem);
        $this->setHydrator(new CartItemHydrator);
    }

    public function findById($itemId)
    {
        $select = new Select;
        $select->from($this->tableName);

        $where = new Where;
        $where->equalTo($this->itemIdField, $itemId);

        $resultSet = $this->selectWith($select->where($where));
        return $resultSet->current();
    }

    public function findByCartId($cartId)
    {
        $hydrator = new CartItemRecursiveHydrator;
        $adapter = $this->getDbAdapter();
        $statement = $adapter->createStatement();

        $where = new Where;
        $where->equalTo('cart_id', $cartId);

        $select = new Select;
        $select->from($this->tableName)
            ->order('parent_item_id ASC')
            ->where($where)
            ->prepareStatement($adapter, $statement);

        $result = $statement->execute();

        $resultSet = new ResultSet(ResultSet::TYPE_ARRAY);
        $resultSet = $resultSet->initialize($result)->toArray();
        $resultSet = $hydrator->hydrate($resultSet, new CartItem);

        return $resultSet;
    }

    public function deleteById($cartItemId)
    {
        $sql = new Sql($this->getDbAdapter(), $this->tableName);

        $where = new Where;
        $where->equalTo($this->itemIdField, $cartItemId);

        $delete = $sql->delete();
        $delete->where($where);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();

        return $result->getAffectedRows();
    }

    public function persist(CartItemInterface $item)
    {
        if ($item->getCartItemId() > 0) {
            $where = new Where;
            $where->equalTo($this->itemIdField, $item->getCartItemId());

            $this->update($item, $where, $this->tableName);
        } else {
            $result = $this->insert($item, $this->tableName);
            $item->setCartItemId($result->getGeneratedValue());
        }

        return $item;
    }

    protected function selectMany($select)
    {
        $resultSet = $this->selectWith($select);

        $return = array();
        foreach ($resultSet as $r) {
            $return[] = $r;
        }

        return $return;
    }
}
