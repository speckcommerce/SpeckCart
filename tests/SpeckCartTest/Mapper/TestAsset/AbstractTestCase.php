<?php

namespace SpeckCartTest\Mapper\TestAsset;

use PHPUnit\Extensions\Database\TestCase;

class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    protected $testMapper;

    public function getTestMapper()
    {
        if (null === $this->testMapper) {
            $this->testMapper =  $this->getServiceManager()->get('speckcart_test_mapper');
        }
        return $this->testMapper;
    }

    public function getServiceManager()
    {
        return \SpeckCartTest\Bootstrap::getServiceManager();
    }

    public function setup()
    {
        $this->getTestMapper()->setup();
    }

    public function teardown()
    {
        $this->getTestMapper()->teardown();
    }
}
