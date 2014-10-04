<?php
return array(
    'service_manager' => array(
        'aliases' => array(
            'speckcart_db_adapter' => 'Zend\Db\Adapter\Adapter'
        ),
    ),
    'doctrine' => [
        'driver' => [
            'speckcommerce_cart_driver' => [
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Speckcommerce/Cart/Domain']
            ],

            'orm_default' => [
                'drivers' => [
                    'Speckcommerce\Cart\Domain' => 'speckcommerce_cart_driver'
                ]
            ]
        ]
    ],
    'view_manager' => array(
        'controller_map' => [
            'SpeckCommerce\Cart' => true,
        ],
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
