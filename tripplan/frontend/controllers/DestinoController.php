<?php

namespace frontend\controllers;


use Yii;
use common\models\Destino;
use common\models\DestinoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
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

                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index','view', 'create', 'update', 'delete'], // Ações protegidas com login
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'], 
                        ]
                    ],
                ],

                'verbs' => [
                    'class' =>  \yii\filters\VerbFilter::class,
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


     * @param int|null $plano_viagem_id (Opcional)
     */
    public function actionCreate($plano_viagem_id = null)
    {
        $model = new Destino();

        // Se recebermos o ID da viagem pela URL, guardamos logo no modelo
        if ($plano_viagem_id) {
            $model->plano_viagem_id = $plano_viagem_id;
        }

        // --- ADICIONE ESTA LINHA AQUI ---
        // Preenche automaticamente o ID do agente logado
        $model->agente_viagem_id = Yii::$app->user->id;
        // --------------------------------

        // Buscar lista de cidades
        $cidadesDisponiveis = Destino::find()
            ->select(['nome_cidade'])
            ->distinct()
            ->orderBy('nome_cidade')
            ->column();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {


                if ($plano_viagem_id) {
                    $model->plano_viagem_id = $plano_viagem_id;
                }

                $model->agente_viagem_id = Yii::$app->user->id;

                if ($model->save()) {
                    return $this->redirect(['plano-viagem/view', 'id' => $model->plano_viagem_id]);
                }
                // Se falhar agora, provavelmente é a data, mas vamos tentar primeiro resolver o ID do agente.
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'cidadesDisponiveis' => $cidadesDisponiveis,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
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

        $plano_id = $model->plano_viagem_id;

        $model->delete();

        return $this->redirect(['plano-viagem/view', 'id' => $plano_id]);
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
