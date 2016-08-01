<?php
/**
 * Application configuration shared by all test types
 */
return \yii\helpers\ArrayHelper::merge([
    'language' => 'en-US',
    'bootstrap' => [],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@tests/codeception/fixtures',
            'templatePath' => '@tests/codeception/templates',
            'namespace' => 'tests\codeception\fixtures',
        ],
    ],
    'components' => [
        'language' => 'en',
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => '',
            'password' => '',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'log' => [],
    ],
    'params' => [
        'baseUrl' => 'http://localhost:8080',
        'auth' => [
            'username' => 'admin',
            'password' => 'admin',
        ],
    ]
], require __DIR__ . '/local.php');
