<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Destino;
use Yii;

class EstadiaController extends ActiveController
{
    public $modelClass = 'common\models\Estadia';

    public function actions()
    {
        $actions = parent::actions();
        // Desativar a ação create padrão para usarmos a nossa personalizada
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new \common\models\Estadia();

        // Carregar os dados enviados pelo Android
        $model->load(Yii::$app->request->post(), '');

        // LÓGICA INTELIGENTE:
        // Se faltar o destino_id mas tivermos o plano_viagem_id, vamos procurar o destino.
        if (empty($model->destino_id) && !empty($model->plano_viagem_id)) {
            $destino = Destino::find()
                ->where(['plano_viagem_id' => $model->plano_viagem_id])
                ->one(); // Pega o primeiro destino que encontrar nessa viagem

            if ($destino) {
                $model->destino_id = $destino->id;
            }
        }

        if ($model->save()) {
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new \yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }
}