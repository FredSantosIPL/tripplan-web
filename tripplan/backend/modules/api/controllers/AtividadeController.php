<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Destino; // Importante para encontrar o destino
use Yii;

class AtividadeController extends ActiveController
{
    public $modelClass = 'common\models\Atividade';

    public function actions()
    {
        $actions = parent::actions();

        // 1. DESLIGAR A AÇÃO PADRÃO
        // Como vamos criar uma actionCreate personalizada, temos de desligar a automática
        unset($actions['create']);

        return $actions;
    }

    public function actionCreate()
    {
        $model = new \common\models\Atividade();

        // 1. Carregar os dados normais (nome, tipo, etc.)
        $model->load(Yii::$app->request->post(), '');

        // 2. LER O ID DA VIAGEM QUE VEM DO ANDROID
        $planoViagemId = Yii::$app->request->post('plano_viagem_id');

        // --- CORREÇÃO AQUI: Forçar a gravação do ID na base de dados ---
        // Se isto não estiver aqui, o modelo pode ignorar o campo se faltar na regra "safe"
        if ($planoViagemId) {
            $model->plano_viagem_id = $planoViagemId;
        }
        // ----------------------------------------------------------------

        // 3. A BATOTA (Descobrir o Destino Automaticamente)
        if (empty($model->destino_id) || $model->destino_id == 0) {
            if (!empty($planoViagemId)) {
                // Procura o PRIMEIRO destino desta viagem
                $destino = Destino::find()
                    ->where(['plano_viagem_id' => $planoViagemId])
                    ->one();

                if ($destino) {
                    $model->destino_id = $destino->id;
                }
            }
        }

        // 4. Gravar
        if ($model->save()) {
            return $model;
        }

        // Se falhar, mostra o erro
        Yii::$app->response->statusCode = 422;
        return $model->getErrors();
    }
}