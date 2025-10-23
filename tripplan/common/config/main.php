<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // 'cache' => 'cache' // Descomente isto se tiver a cache configurada
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];
