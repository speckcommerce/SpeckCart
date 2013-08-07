<?php
return array(
    'service_manager' => array(
        'aliases' => array(
            'speckcart_db_adapter' => 'Zend\Db\Adapter\Adapter'
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'speckcart' => 'SpeckCart\Controller\CartController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'cart' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/cart',
                    'defaults' => array(
                        'controller' => 'speckcart',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'empty-cart' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/empty-cart',
                            'defaults' => array(
                                'controller' => 'speckcart',
                                'action' => 'empty-cart',
                            ),
                        ),
                    ),
                    'update-quantities' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/update-quantities',
                            'defaults' => array(
                                'controller' => 'speckcart',
                                'action' => 'update-quantities',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
