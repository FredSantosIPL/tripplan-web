<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

class FotosMemoriasController extends ActiveController
{
    public $modelClass = 'common\models\FotosMemorias';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }
}