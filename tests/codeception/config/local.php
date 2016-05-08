<?php
/**
 * Application configuration shared by all test types
 */
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=sitown_test',
            'username' => 'root',
            'password' => 'root',
        ],
    ],
];
