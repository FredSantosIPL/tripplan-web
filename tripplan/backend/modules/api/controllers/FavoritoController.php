<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth; // Se tiveres autenticação, usa. Se não, comenta.
use common\models\Favorito;
use yii\data\ActiveDataProvider;

class FavoritoController extends ActiveController
{
    public $modelClass = 'common\models\Favorito';

    // Desativar a validação de sessão para APIs (Importante para POST/PUT funcionar)
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Remove autenticação por cookie/sessão que o Yii usa por defeito na web
        // Isto evita erros de CSRF no Android
        unset($behaviors['authenticator']);

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Vamos personalizar a ação "index" (Listar)
        // Para podermos filtrar por user_id: GET /favoritos?user_id=5
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $query = Favorito::find();

        // 1. Filtrar pelo user_id se ele vier no URL
        $userId = \Yii::$app->request->get('user_id');
        if ($userId) {
            $query->andWhere(['user_id' => $userId]);
        }


        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }
}