<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SpeckCart;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface
{
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'SpeckCart\Service\CartService' => function($sm) {
                    $service = new Service\CartService;
                    $service->setItemMapper($sm->get('SpeckCart\Mapper\CartItemMapperZendDb'));
                    $service->setCartMapper($sm->get('SpeckCart\Mapper\CartMapperZendDb'));
                    $service->setEventManager($sm->get('EventManager'));
                    $service->attachDefaultListeners();
                    return $service;
                },

                'SpeckCart\Mapper\CartMapperZendDb' => function($sm) {
                    $mapper = new Mapper\CartMapperZendDb;
                    $mapper->setDbAdapter($sm->get('speckcart_db_adapter'));
                    return $mapper;
                },

                'SpeckCart\Mapper\CartItemMapperZendDb' => function($sm) {
                    $mapper = new Mapper\CartItemMapperZendDb;
                    $mapper->setDbAdapter($sm->get('speckcart_db_adapter'));
                    return $mapper;
                },
            ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
}
