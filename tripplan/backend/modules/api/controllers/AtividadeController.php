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

        // Intercetar a ação de criar (create) para adicionar a lógica "inteligente"
        $actions['create']['class'] = 'yii\rest\CreateAction';
        $actions['create']['modelClass'] = $this->modelClass;
        $actions['create']['checkAccess'] = [$this, 'checkAccess'];
        $actions['create']['scenario'] = $this->createScenario;

        // Aqui está o truque: Modificar o body params antes de salvar
        $actions['create']['findModel'] = function($id, $action) {
            // Se precisasses de lógica de find customizada...
        };

        return $actions;
    }

    public function actionCreate()
    {
        $model = new \common\models\Atividade();

        // Carrega os dados que vêm do Android (JSON)
        $model->load(Yii::$app->request->post(), '');

        // 1. A BATOTA: Tentar descobrir o destino_id se não vier preenchido
        if (empty($model->destino_id) && !empty($model->plano_viagem_id)) {
            // Procura o PRIMEIRO destino dessa viagem
            $destino = Destino::find()
                ->where(['plano_viagem_id' => $model->plano_viagem_id])
                ->one();

            if ($destino) {
                $model->destino_id = $destino->id;
            } else {
                // Se a viagem não tiver destinos, cria um "Destino Geral" automático?
                // Ou retorna erro. Por agora, vamos assumir que falha.
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