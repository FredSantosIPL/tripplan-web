<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\FotosMemorias;
use Yii;

class FotosMemoriasController extends ActiveController
{
    public $modelClass = 'common\models\FotosMemorias';

    public function actions()
    {
        $actions = parent::actions();
        // Desativar o create padrão para usarmos o nosso customizado
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new FotosMemorias();

        // 1. Receber os dados
        $params = Yii::$app->request->post();

        $model->plano_viagem_id = isset($params['plano_viagem_id']) ? $params['plano_viagem_id'] : null;
        $model->comentario = isset($params['comentario']) ? $params['comentario'] : '';

        // --- CORREÇÃO DO UTILIZADOR (SAFETY NET) ---
        // 1. Tenta pelo Login
        if (!Yii::$app->user->isGuest) {
            $model->user_id = Yii::$app->user->id;
        }
        // 2. Tenta pelo POST do Android
        elseif (isset($params['user_id'])) {
            $model->user_id = $params['user_id'];
        }

        // 3. (A MAGIA) Se ainda for NULL, vai buscar o dono da Viagem!
        if (empty($model->user_id) && !empty($model->plano_viagem_id)) {
            $viagem = \common\models\PlanoViagem::findOne($model->plano_viagem_id);
            if ($viagem) {
                $model->user_id = $viagem->user_id; // Atribui a foto ao dono da viagem
            }
        }
        // -------------------------------------------

        // 2. Receber a Imagem Base64
        $base64Data = isset($params['imagem_base64']) ? $params['imagem_base64'] : null;

        if ($base64Data) {
            $pastaUploads = Yii::getAlias('@frontend/web/uploads/');
            if (!file_exists($pastaUploads)) {
                mkdir($pastaUploads, 0777, true);
            }

            $nomeFicheiro = 'memoria_' . time() . '_' . rand(1000, 9999) . '.jpg';
            $caminhoCompleto = $pastaUploads . $nomeFicheiro;

            $dadosBinarios = base64_decode($base64Data);

            if ($dadosBinarios === false) {
                throw new \yii\web\BadRequestHttpException('Base64 inválido.');
            }

            if (file_put_contents($caminhoCompleto, $dadosBinarios)) {
                $model->foto = $nomeFicheiro; // Define o nome do ficheiro no modelo
            } else {
                throw new \yii\web\ServerErrorHttpException('Erro ao gravar ficheiro no disco.');
            }
        }

        // 4. Gravar na BD
        if ($model->save()) {
            return $model;
        } else {
            return $model->getErrors();
        }
    }
}