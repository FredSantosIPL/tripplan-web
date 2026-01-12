<?php

namespace backend\modules\api\controllers;
use yii\rest\ActiveController;

class DestinoController extends ActiveController
{
    public $modelClass = 'common\models\Destino';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }
}