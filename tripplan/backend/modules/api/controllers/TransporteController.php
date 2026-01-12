<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class TransporteController extends ActiveController
{
    // Define que este controlador gere a tabela 'transporte'
    public $modelClass = 'common\models\Transporte';
}