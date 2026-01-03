<?php

namespace backend\controllers;

use common\models\Destino;
use common\models\DestinoSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DestinoController implements the CRUD actions for Destino model.
 */
class DestinoController extends Controller
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
     * Lists all Destino models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DestinoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Destino model.
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
     * Creates a new Destino model.
     * MODIFICADO: Aceita plano_viagem_id opcional para pré-preencher
     * @param int|null $plano_viagem_id
     * @return string|\yii\web\Response
     */
    public function actionCreate($plano_viagem_id = null)
    {
        $model = new Destino();

        // A tua lógica original (mantida)
        $model->agente_viagem_id = Yii::$app->user->identity->id;

        // NOVA LÓGICA: Se vier do botão "Adicionar" no Plano de Viagem
        if ($plano_viagem_id) {
            $model->plano_viagem_id = $plano_viagem_id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                // Redirecionamento inteligente:
                // Se pertence a um plano, volta para o plano. Senão, vai para a view do destino.
                if ($model->plano_viagem_id) {
                    return $this->redirect(['/plano-viagem/view', 'id' => $model->plano_viagem_id]);
                }

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
     * Updates an existing Destino model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            // Redirecionamento inteligente após editar
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
     * Deletes an existing Destino model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Guarda o ID do plano antes de apagar para poder voltar atrás
        $planoId = $model->plano_viagem_id;

        $model->delete();

        // Se tinha plano associado, volta para o plano
        if ($planoId) {
            return $this->redirect(['/plano-viagem/view', 'id' => $planoId]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Destino model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Destino the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Destino::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}