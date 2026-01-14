<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\UploadedFile;
use common\models\FotosMemorias;
use Yii;

class FotosMemoriasController extends ActiveController
{
    public $modelClass = 'common\models\FotosMemorias';

    public function actions()
    {
        $actions = parent::actions();
        // Desativar a ação create padrão para usarmos a nossa com upload
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new FotosMemorias();

        // 1. Receber os dados de texto (ID da viagem e Comentário)
        // Nota: Como é multipart/form-data, usamos Yii::$app->request->post() direto
        $model->plano_viagem_id = Yii::$app->request->post('plano_viagem_id'); // O Android tem de enviar com este nome
        $model->comentario = Yii::$app->request->post('comentario');

        $model->user_id = Yii::$app->request->post('user_id');

        // Se o Android enviar apenas "id" em vez de "plano_viagem_id", fazemos a conversão:
        if (empty($model->plano_viagem_id)) {
            $model->plano_viagem_id = Yii::$app->request->post('id');
        }

        // 2. Receber o Ficheiro
        $fotoUpload = UploadedFile::getInstanceByName('foto'); // "foto" é o nome que definiste no MultipartBody do Android

        if ($fotoUpload) {
            // Gerar um nome único para a imagem (ex: memoria_123456.jpg)
            $nomeFicheiro = 'memoria_' . time() . '_' . rand(100, 999) . '.' . $fotoUpload->extension;

            // Definir onde guardar (na pasta pública do frontend)
            $caminhoPasta = Yii::getAlias('@frontend/web/uploads/');

            // Criar a pasta se não existir
            if (!file_exists($caminhoPasta)) {
                mkdir($caminhoPasta, 0777, true);
            }

            $caminhoCompleto = $caminhoPasta . $nomeFicheiro;

            // 3. Guardar o ficheiro no disco
            if ($fotoUpload->saveAs($caminhoCompleto)) {
                // Guardar apenas o nome do ficheiro na Base de Dados
                $model->foto = $nomeFicheiro;

                // Gravar na BD
                if ($model->save()) {
                    return $model;
                } else {
                    return $model->getErrors();
                }
            } else {
                throw new \yii\web\ServerErrorHttpException('Falha ao gravar o ficheiro no servidor.');
            }
        }

        throw new \yii\web\BadRequestHttpException('Nenhuma imagem enviada. (Campo "foto" vazio)');
    }
}