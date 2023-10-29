<?php

return [
    'driver'   => 'pdo_mysql',
    'host'     => getenv('HOST_MYSQL') ? getenv('HOST_MYSQL') : 'localhost',
    'user'     => getenv('USER_MYSQL') ? getenv('USER_MYSQL') : 'root',
    'password' => getenv('PASS_MYSQL') ? getenv('PASS_MYSQL') : 'root',
    'dbname'   => getenv('DB_MYSQL') ? getenv('DB_MYSQL') : 'ecommerce_zend_desafio_php',
];