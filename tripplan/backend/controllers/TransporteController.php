<?php

namespace backend\controllers;

use common\models\Transporte;
use common\models\TransporteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransporteController implements the CRUD actions for Transporte model.
 */
class TransporteController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Transporte models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TransporteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transporte model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transporte model.
     * MODIFICADO: Aceita o ID do plano para pré-preenchimento
     * @param int|null $plano_viagem_id
     * @return string|\yii\web\Response
     */
    public function actionCreate($plano_viagem_id = null)
    {
        $model = new Transporte();

        // 1. Se vier o ID no URL (clicou em "Adicionar" na viagem), preenche logo
        if ($plano_viagem_id) {
            $model->plano_viagem_id = $plano_viagem_id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                // 2. Redirecionamento Inteligente:
                // Se tem plano associado, volta para a dashboard da viagem
                if ($model->plano_viagem_id) {
                    return $this->redirect(['/plano-viagem/view', 'id' => $model->plano_viagem_id]);
                }

                // Senão, vai para a view do transporte (comportamento padrão)
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transporte model.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            // Redirecionamento Inteligente após editar
            if ($model->plano_viagem_id) {
                return $this->redirect(['/plano-viagem/view', 'id' => $model->plano_viagem_id]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transporte model.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Guarda o ID do plano antes de apagar
        $planoId = $model->plano_viagem_id;

        $model->delete();

        // Se pertencia a um plano, volta para lá
        if ($planoId) {
            return $this->redirect(['/plano-viagem/view', 'id' => $planoId]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transporte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transporte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transporte::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}