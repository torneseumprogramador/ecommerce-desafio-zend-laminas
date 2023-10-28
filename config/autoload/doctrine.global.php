<?php

return [
    'doctrine' => [
        'driver' => [
            'application_entities' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../../modulo/Application/src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'application_entities'
                ],
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\Mysqli\Driver::class,
                'params' => [
                    'host'     => getenv('HOST_MYSQL') ? getenv('HOST_MYSQL') : 'localhost',
                    'user'     => getenv('USER_MYSQL') ? getenv('USER_MYSQL') : 'root',
                    'password' => getenv('PASS_MYSQL') ? getenv('PASS_MYSQL') : 'root',
                    'dbname'   => getenv('DB_MYSQL') ? getenv('DB_MYSQL') : 'ecommerce_zend_desafio_php',
                ],
            ],
        ],
    ],
];