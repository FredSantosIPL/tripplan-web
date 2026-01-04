<?php

namespace frontend\controllers;

use common\models\FotosMemorias;
use common\models\FotosMmemoriasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FotosMemoriasController implements the CRUD actions for FotosMemorias model.
 */
class FotosMemoriasController extends Controller
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
     * Lists all FotosMemorias models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FotosMmemoriasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FotosMemorias model.
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
     * Creates a new FotosMemorias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */


    public function actionCreate($plano_id)
    {
        $model = new FotosMemorias();
        $model->plano_viagem_id = $plano_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                // --- A CORREÇÃO ESTÁ AQUI ---
                // Forçamos o ID do utilizador AGORA, para garantir que não vem vazio do formulário
                $model->user_id = \Yii::$app->user->id;

                // Captura o ficheiro
                $imagem = UploadedFile::getInstance($model, 'foto');

                if ($imagem) {
                    $nomeFicheiro = 'memoria_' . time() . '_' . rand(100, 999) . '.' . $imagem->extension;
                    $caminho = \Yii::getAlias('@frontend/web/uploads/') . $nomeFicheiro;

                    if ($imagem->saveAs($caminho)) {
                        $model->foto = $nomeFicheiro;
                    }
                }

                // Tenta salvar e redirecionar
                if ($model->save()) {
                    return $this->redirect(['/plano-viagem/view', 'id' => $plano_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FotosMemorias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Guardar o nome da foto antiga caso o user não carregue uma nova
        $fotoAntiga = $model->foto;

        if ($this->request->isPost && $model->load($this->request->post())) {

            // Verifica se foi carregada uma NOVA foto
            $imagem = \yii\web\UploadedFile::getInstance($model, 'foto');

            if ($imagem) {
                // Se sim, faz o upload da nova
                $nomeFicheiro = 'memoria_' . time() . '_' . rand(100, 999) . '.' . $imagem->extension;
                $caminho = \Yii::getAlias('@frontend/web/uploads/') . $nomeFicheiro;

                if ($imagem->saveAs($caminho)) {
                    $model->foto = $nomeFicheiro;
                }
            } else {
                // Se não, mantém a foto que já lá estava
                $model->foto = $fotoAntiga;
            }

            if ($model->save()) {
                // AQUI ESTÁ O REDIRECIONAMENTO QUE QUERES:
                return $this->redirect(['/plano-viagem/view', 'id' => $model->plano_viagem_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FotosMemorias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);

        // 2. Guardar o ID do plano (O "Pai") ANTES de apagar
        $plano_id = $model->plano_viagem_id;

        // 3. Apagar a foto da Base de Dados
        $model->delete();

        // 4. Redirecionar para a página da Viagem
        return $this->redirect(['/plano-viagem/view', 'id' => $plano_id]);
    }

    /**
     * Finds the FotosMemorias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FotosMemorias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FotosMemorias::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
