<?php
$mainConfig = require 'web.php';
return [
    'id' => 'console',
    'bootstrap' => ['log'],
    'name'  => $mainConfig['name'],
    'language'  => $mainConfig['language'],
    'timeZone' => $mainConfig['timeZone'],
    'basePath' => $mainConfig['basePath'],
    'extensions'=> require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'db'            => $mainConfig['components']['db'],
        'mailer'        => $mainConfig['components']['mailer'],
        'cache'         => ['class' => 'yii\caching\DummyCache'],
        'authManager'   => $mainConfig['components']['authManager'],
        'urlManager'    => array_merge($mainConfig['components']['urlManager'], [
            'baseUrl' => $mainConfig['params']['baseUrl']
        ]),
        'i18n'          => $mainConfig['components']['i18n'],
        'event'         => $mainConfig['components']['event'],
        //'view'          => $mainConfig['components']['view'],
        'formatter'     => $mainConfig['components']['formatter'],
        'log'           => $mainConfig['components']['log'],
        'github'           => $mainConfig['components']['github'],
    ],
    'controllerMap' => [
        'migrate'   => [
            'class' => 'bariew\moduleMigration\ModuleMigrateController',
            'migrationPath' => '@app/modules/base/migrations'
        ]
    ],
    'modules' => $mainConfig['modules'],
    'params' =>  $mainConfig['params'],
];
