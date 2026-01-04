<?php

namespace frontend\controllers;

use common\models\Review;
use common\models\Destino;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ReviewController extends Controller
{
    /**
     * Apenas utilizadores logados podem criar reviews
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'], // '@' significa utilizador autenticado
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Cria uma nova Review para um Destino específico
     */
    public function actionCreate($destino_id)
    {
        // Verifica se o destino existe mesmo
        $destino = Destino::findOne($destino_id);
        if (!$destino) {
            throw new NotFoundHttpException('O destino não foi encontrado.');
        }

        $model = new Review();

        // Preenche dados automáticos
        $model->destino_id = $destino_id;
        $model->utilizador_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Obrigado! A tua avaliação foi registada.');
                return $this->redirect(['/destino/view', 'id' => $destino_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'destino' => $destino,
        ]);
    }
}