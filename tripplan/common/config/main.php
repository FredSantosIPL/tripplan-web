<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
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
//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'showScriptName' => false, // Ocultar o index.php
//            'enableStrictParsing' => false,
//            'rules' => [
//                // Regras para a API REST
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/trip'],
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/activity'],
//            ],
//        ],
    ],

];
