<?php

namespace SpeckCartTest\Mapper;

use PHPUnit_Framework_TestCase;
use SpeckCart\Entity\Cart;
use SpeckCart\Mapper\CartMapperZendDb;
use Bootstrap;

class CartMapperZendDbTest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->mapper = Bootstrap::getServiceManager()->get('SpeckCart\Mapper\CartMapperZendDb');
        $this->mapper->getDbAdapter()->query('TRUNCATE cart', 'execute');
    }

    public function testPersistInsert()
    {
        $time = new \DateTime();

        $cart = new Cart;
        $cart->setCreatedTime($time);

        $this->mapper->persist($cart);
        $this->mapper->persist($cart);

        $cart = $this->mapper->findById(1);
        $this->assertEquals(1, $cart->getCartId());
        $this->assertEquals($time->format('c'), $cart->getCreatedTime()->format('c'));
    }

    public function testPersistUpdate()
    {
        $time = new \DateTime();

        $cart = new Cart;
        $cart->setCartId(1);
        $cart->setCreatedTime($time);

        $cart = $this->mapper->findById(1);
        $this->assertEquals(1, $cart->getCartId());
        $this->assertEquals($time->format('c'), $cart->getCreatedTime()->format('c'));
    }

    public function testFindById()
    {
        $cart = $this->mapper->findById(1);
        $this->assertEquals(1, $cart->getCartId());

        $cart = $this->mapper->findById(2);
        $this->assertEquals(2, $cart->getCartId());
    }
}
