<?php
return array(
    'service_manager' => array(
        'aliases' => array(
            'speckcart_db_adapter' => 'Zend\Db\Adapter\Adapter'
        ),
    ),
    'view_manager' => array(
        'controller_map' => [
            'SpeckCommerce\Cart' => true,
        ],
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
