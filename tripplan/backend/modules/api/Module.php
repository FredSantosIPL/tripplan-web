<?php

namespace backend\modules\api;
use yii\base\Module as BaseModule;

/**
 * api module definition class
 */
class Module extends BaseModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
