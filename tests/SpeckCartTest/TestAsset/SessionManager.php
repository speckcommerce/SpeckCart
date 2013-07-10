<?php

namespace SpeckCartTest\TestAsset;

use Zend\EventManager\EventManagerInterface;
use Zend\Session\AbstractManager;
use Zend\Session\Configuration\ConfigurationInterface as SessionConfig;
use Zend\Session\SaveHandler\SaveHandlerInterface as SessionSaveHandler;
use Zend\Session\Storage\StorageInterface as SessionStorage;

class SessionManager extends AbstractManager
{
    public $started = false;

    protected $configDefaultClass = 'Zend\\Session\\Configuration\\StandardConfig';
    protected $storageDefaultClass = 'Zend\\Session\\Storage\\ArrayStorage';

    public function start()
    {
        $this->started = true;
    }

    public function destroy()
    {
        $this->started = false;
    }

    public function stop()
    {}

    public function writeClose()
    {
        $this->started = false;
    }

    public function getName()
    {}

    public function setName($name)
    {}

    public function getId()
    {}

    public function setId($id)
    {}

    public function regenerateId()
    {}

    public function rememberMe($ttl = null)
    {}

    public function forgetMe()
    {}


    public function setValidatorChain(EventManagerInterface $chain)
    {}

    public function getValidatorChain()
    {}

    public function isValid()
    {}


    public function sessionExists()
    {}

    public function expireSessionCookie()
    {}
}

