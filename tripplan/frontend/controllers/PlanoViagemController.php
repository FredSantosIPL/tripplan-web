<?php

namespace frontend\controllers;

use common\models\PlanoViagem;
use common\models\PlanoViagemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Destino;
use common\models\PlanoDestino;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * PlanoViagemController implements the CRUD actions for PlanoViagem model.
 */
class PlanoViagemController extends Controller
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
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // Usuários logados
                        ],
                    ],

                    'denyCallback' => function ($rule, $action) {
                        return $this->redirect(['/site/login']);
                    },
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
     * Lists all PlanoViagem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PlanoViagemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlanoViagem model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $destinosProvider = new \yii\data\ActiveDataProvider([
            'query' => \common\models\Destino::find()->where(['plano_viagem_id' => $id]),
        ]);

        // Criar o DataProvider para as Estadias deste plano
        $estadiasProvider = new \yii\data\ActiveDataProvider([
            'query' => \common\models\Estadia::find()->where(['plano_viagem_id' => $id]),
        ]);

        return $this->render('view', [
            'model' => $model,
            'destinosProvider' => $destinosProvider, // O que já tinhas
            'estadiasProvider' => $estadiasProvider, // Adiciona esta linha
        ]);
    }

    /**
     * Creates a new PlanoViagem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PlanoViagem();

        // Se receber dados do formulário (POST)
        if ($model->load($this->request->post())) {

            $model->user_id = \Yii::$app->user->id;

            // Tenta gravar a Viagem principal
            if ($model->save()) {

                // --- INÍCIO DA GRAVAÇÃO DOS DESTINOS ---
                $postData = $this->request->post('PlanoViagem');

                // O operador ?? [] evita erro se não vier nada
                $destinosEscolhidos = $postData['destinos_id'] ?? [];

                // CORREÇÃO: Garante que é sempre uma lista, mesmo que seja só 1
                if (!empty($destinosEscolhidos) && !is_array($destinosEscolhidos)) {
                    $destinosEscolhidos = [$destinosEscolhidos];
                }

                if (!empty($destinosEscolhidos)) {
                    foreach ($destinosEscolhidos as $destinoId) {
                        $ligacao = new \common\models\PlanoDestino();
                        $ligacao->plano_id = $model->id;
                        $ligacao->destino_id = $destinoId;
                        $ligacao->save();
                    }
                }
                // --- FIM DA GRAVAÇÃO DOS DESTINOS ---

                return $this->redirect(['view', 'id' => $model->id]);

            } else {
                // DEBUG: Se falhar ao gravar, mostra o erro no ecrã para tu veres
                // Podes apagar isto depois de estar a funcionar
                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
                die();
            }
        } else {
            $model->loadDefaultValues();
        }

        // Prepara a lista para o dropdown
        $listaDestinos = \common\models\Destino::find()
            ->select(['nome_cidade', 'id'])
            ->indexBy('id')
            ->column();

        return $this->render('create', [
            'model' => $model,
            'listaDestinos' => $listaDestinos,
        ]);
    }

    /**
     * Updates an existing PlanoViagem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
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
     * Deletes an existing PlanoViagem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlanoViagem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PlanoViagem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        // Tenta encontrar um plano que tenha AQUELE id E que pertença ao UTILIZADOR logado
        $model = \common\models\PlanoViagem::findOne([
            'id' => $id,
            'user_id' => Yii::$app->user->id
        ]);

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Página não encontrada ou sem permissão.');
    }
}
