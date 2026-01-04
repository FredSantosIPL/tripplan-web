<?php

namespace frontend\controllers;

use common\models\Estadia;
use common\models\EstadiaSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstadiaController implements the CRUD actions for Estadia model.
 */
class EstadiaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index','view', 'create', 'update', 'delete'], // Ações protegidas com login
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'], // '@' só para utilizadores com login feito
                        ]
                    ],
                ],

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
     * Lists all Estadia models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EstadiaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estadia model.
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
     * Creates a new Estadia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($destino_id)
    {
        $model = new Estadia();

        $model->destino_id = $destino_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                return $this->redirect(['destino/view', 'id' => $model->destino_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Estadia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // --- NÃO FAZEMOS CONVERSÃO AQUI ---
        // Deixamos a data ir como '2026-06-04' para o formulário.
        // O navegador vai perceber e mostrar automaticamente como '04/06/2026'.

        if ($this->request->isPost) {
            $postData = $this->request->post();

            if ($model->load($postData)) {

                // --- TESTE DE SEGURANÇA ---
                // Se o navegador enviar a data já certa (Y-m-d), não fazemos nada.
                // Se enviar em PT (d/m/Y), convertemos.
                $dataTeste = \DateTime::createFromFormat('d/m/Y', $model->data_checkin);
                if ($dataTeste) {
                    $model->data_checkin = $dataTeste->format('Y-m-d');
                }

                if ($model->save()) {
                    return $this->redirect(['plano-viagem/view', 'id' => $model->plano_viagem_id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Estadia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // 1. Buscar o modelo para saber quem é o "Pai" (Destino) antes de apagar
        $model = $this->findModel($id);
        $destino_id = $model->destino_id;

        // 2. Apagar
        $model->delete();

        // 3. Voltar para a página do Destino
        return $this->redirect(['destino/view', 'id' => $destino_id]);
    }

    /**
     * Finds the Estadia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Estadia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Estadia::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
