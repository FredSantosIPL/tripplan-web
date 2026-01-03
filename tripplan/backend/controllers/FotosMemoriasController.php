<?php

namespace backend\controllers;

use common\models\FotosMemorias;
use common\models\FotosMemoriasSearch;
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
        $searchModel = new FotosMemoriasSearch();
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
     * MODIFICADO: Aceita plano_viagem_id e gere upload
     * @param int|null $plano_viagem_id
     * @return string|\yii\web\Response
     */
    public function actionCreate($plano_viagem_id = null)
    {
        $model = new FotosMemorias();

        // 1. Pré-preencher ID da viagem se vier no URL
        if ($plano_viagem_id) {
            $model->plano_viagem_id = $plano_viagem_id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                // 2. Capturar o ficheiro de imagem
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                // 3. Tentar fazer upload (a função upload() deve estar no Model)
                // Se o upload correr bem, grava na BD. 'save(false)' salta validações repetidas.
                if ($model->upload() && $model->save(false)) {

                    // 4. Redirecionamento Inteligente
                    if ($model->plano_viagem_id) {
                        return $this->redirect(['/plano-viagem/view', 'id' => $model->plano_viagem_id]);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
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
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            // Lógica de substituição de imagem
            $novoFicheiro = UploadedFile::getInstance($model, 'imageFile');
            if ($novoFicheiro) {
                $model->imageFile = $novoFicheiro;
                // O método upload() encarrega-se de atualizar a propriedade 'foto' com o novo caminho
                $model->upload();
            }

            if ($model->save(false)) {
                // Redirecionamento Inteligente
                if ($model->plano_viagem_id) {
                    return $this->redirect(['/plano-viagem/view', 'id' => $model->plano_viagem_id]);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FotosMemorias model.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $planoId = $model->plano_viagem_id; // Guardar ID antes de apagar

        // Opcional: Apagar ficheiro físico (unlink) se quiseres limpar o disco
        // if (file_exists(Yii::getAlias('@frontend/web/') . $model->foto)) { ... }

        $model->delete();

        if ($planoId) {
            return $this->redirect(['/plano-viagem/view', 'id' => $planoId]);
        }

        return $this->redirect(['index']);
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