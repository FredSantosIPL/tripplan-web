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

        $dataProvider->query->joinWith('planoViagem');

        $dataProvider->query->andWhere(['plano_viagem.user_id' => \Yii::$app->user->id]);

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

        // Se vier ID pelo URL, guarda
        if ($plano_viagem_id) {
            $model->plano_viagem_id = $plano_viagem_id;
        }

        $cidadesDisponiveis = Destino::find()
            ->select(['nome_cidade'])
            ->distinct()
            ->orderBy('nome_cidade')
            ->column();

        if ($this->request->isPost) {
            // Define a variável que estava em falta
            $postData = $this->request->post();

            if ($model->load($postData)) {

                // 1. Agente
                $model->agente_viagem_id = Yii::$app->user->id;

                // 2. Data
                $data = \DateTime::createFromFormat('d/m/Y', $model->data_chegada);
                if ($data) {
                    $model->data_chegada = $data->format('Y-m-d');
                }

                // 3. Força o ID da viagem (A tal "Martelada")
                if (empty($model->plano_viagem_id) && $plano_viagem_id) {
                    $model->plano_viagem_id = $plano_viagem_id;
                }
                // Se ainda estiver vazio, tenta ir buscar diretamente aos dados enviados
                if (empty($model->plano_viagem_id) && isset($postData['Destino']['plano_viagem_id'])) {
                    $model->plano_viagem_id = $postData['Destino']['plano_viagem_id'];
                }

                if ($model->save()) {
                    return $this->redirect(['plano-viagem/view', 'id' => $model->plano_viagem_id]);
                } else {
                    var_dump($model->getErrors());
                    die();
                }
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
        // Vai buscar a data como está na BD (ex: '2026-06-04')
        $model = $this->findModel($id);

        //  lista    as cidades
        $cidadesDisponiveis = Destino::find()
            ->select(['nome_cidade'])
            ->distinct()
            ->orderBy('nome_cidade')
            ->column();

        if ($this->request->isPost && $model->load($this->request->post())&& $model->save()) {

            $data = \DateTime::createFromFormat('d/m/Y', $model->data_chegada);
            if ($data) {
                $model->data_chegada = $data->format('Y-m-d');
            }

            if ($model->save()) {
                return $this->redirect(['plano-viagem/view', 'id' => $model->plano_viagem_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'cidadesDisponiveis' => $cidadesDisponiveis,
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

        // 1. Guarda o ID da viagem para saber para onde voltar
        $planoId = $model->plano_viagem_id;

        // 2. O TRUQUE: Apaga os hotéis deste destino primeiro!
        // Assim a "âncora" solta-se e já podes apagar o destino.
        \common\models\Estadia::deleteAll(['destino_id' => $id]);

        // 3. Apaga o destino
        $model->delete();

        // 4. Volta para a viagem correta
        return $this->redirect(['plano-viagem/view', 'id' => $planoId]);
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
