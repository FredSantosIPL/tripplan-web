<?php

namespace frontend\controllers;

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
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // 1. Receber o ID do plano como argumento (vem da URL)
    public function actionCreate($plano_viagem_id)
    {
        $model = new \common\models\Transporte();

        // 2. Definir o ID logo no início
        $model->plano_viagem_id = $plano_viagem_id;

        if ($this->request->isPost) {
            // Carrega os dados do formulário, mas NÃO salva ainda
            if ($model->load($this->request->post())) {

                // 3. CORREÇÃO DA DATA: Feita ANTES de salvar/validar
                // O input datetime-local envia "YYYY-MM-DDTHH:MM", o MySQL quer "YYYY-MM-DD HH:MM:SS"
                $model->data_partida = str_replace('T', ' ', $model->data_partida);

                // Opcional: Se precisar de garantir os segundos
                // if (strlen($model->data_partida) == 16) { $model->data_partida .= ':00'; }

                // 4. Agora sim, tenta salvar
                if ($model->save()) {
                    // Sucesso: Volta para a página da Viagem Geral (não para o transporte sozinho)
                    return $this->redirect(['/plano-viagem/view', 'id' => $plano_viagem_id]);
                }

                // Se falhar (else), o código continua para baixo e mostra o formulário com os erros pintados de vermelho automaticamente.
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
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            // --- MUDANÇA AQUI ---
            // Em vez de ir para a view do transporte ['view', 'id' => $model->id]
            // Redireciona para o Plano de Viagem usando o ID que está guardado no transporte
            return $this->redirect(['/plano-viagem/view', 'id' => $model->plano_viagem_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transporte model.
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

        return $this->redirect(['/plano-viagem/view', 'id' => $plano_id]);
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
