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
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/trip',
                        'api/transporte',
                        'api/destino',
                        'api/atividade',
                        'api/fotos-memorias',
                        'api/estadia',
                        'api/fotos-memorias',
                        'api/favorito',
                    ],
                    'pluralize' => false,
                ],
                'POST api/auth/login' => 'api/auth/login',
                'POST api/auth/signup' => 'api/auth/signup',
            ],
        ],
    ], // <-- ARRAY DE COMPONENTES FECHA AQUI
    'params' => $params,
];