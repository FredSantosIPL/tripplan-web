<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\Module',
        ],
    ],
    'components' => [ // <-- ARRAY DE COMPONENTES COMEÇA AQUI
        //'view' => [
        //    'theme' => [
        //        'pathMap' => [
        //            '@backend/views' => '@vendor/hail812/yii2-adminlte3/src/views'
        //        ],
        //    ],
        //],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/trip'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/transporte'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/destino'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/atividade'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/fotos-memorias'],

                'POST api/auth/login' => 'api/auth/login',
            ],
        ],
    ], // <-- ARRAY DE COMPONENTES FECHA AQUI
    'params' => $params,
];