<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

class AtividadeController extends ActiveController
{
    public $modelClass = 'common\models\Atividade';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }
}