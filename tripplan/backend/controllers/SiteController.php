<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\PlanoViagem;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    // 1. Login e Error: Permitido a todos (convidados e logados)
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],

                    // 2. Logout: Permitido a qualquer utilizador autenticado (@)
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['acederBackofficeAgente'],
                    ],

                    // 3. Index (Dashboard): Restrito apenas a Agentes (e Admins por herança)
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['agente'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
                'layout' => Yii::$app->user->isGuest ? 'main-login' : 'main',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // 1. Count total users
        $totalUsers = \common\models\User::find()->count();

        // 2. Count agents only (using the assignment table)
        // This performs a join to count how many users have the 'agente' role
        $totalAgents = \common\models\User::find()
            ->alias('u')
            ->innerJoin('auth_assignment a', 'a.user_id = u.id')
            ->where(['a.item_name' => 'agente'])
            ->count();

        $totalTrips = PlanoViagem::find()->count();

        return $this->render('index', [
            'totalUsers' => $totalUsers,
            'totalAgents' => $totalAgents,
            'totalTrips' => $totalTrips, // <--- Send variable to view
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if (Yii::$app->user->can('acederBackOfficeAgente')) {
                return $this->goBack();
            }
            Yii::$app->user->logout();
            $model->addError('password', 'Não tem permissão para aceder ao sistema');


            return $this->render('login', [
                'model' => $model,
            ]);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
