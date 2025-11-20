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
                    // Isto resolve o teu problema. Não importa o role, se está logado, pode sair.
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
            return $this->goBack();
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
