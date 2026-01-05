<?php

namespace frontend\controllers;

use common\models\Atividade;
use common\models\AtividadeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AtividadeController implements the CRUD actions for Atividade model.
 */
class AtividadeController extends Controller
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
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // Só permite utilizadores logados (@)
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return $this->redirect(['/site/login']); // Manda para o login se não estiver logado
                    },
                ],
            ]
        );
    }
    /**
     * Lists all Atividade models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AtividadeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->joinWith('planoViagem');

        $dataProvider->query->andWhere(['plano_viagem.user_id' => \Yii::$app->user->id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Atividade model.
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
     * Creates a new Atividade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($plano_viagem_id = null)
    {
        $model = new \common\models\Atividade();

        // Se o ID vier na barra de endereço, preenchemos o modelo
        if ($plano_viagem_id) {
            $model->plano_viagem_id = $plano_viagem_id;
        }

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
     * Updates an existing Atividade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Atividade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $destino_id = $model->destino_id;
        $model->delete();

        return $this->redirect(['destino/view', 'id' => $destino_id]);
    }

    /**
     * Finds the Atividade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Atividade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Atividade::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
