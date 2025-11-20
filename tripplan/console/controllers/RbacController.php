<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;


class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        echo "A criar roles...\n";

        //Role: Viajante
        $viajante = $auth->createRole('viajante');
        $auth->add($viajante);

        //Role: Agente
        $agente = $auth->createRole('agente');
        $auth->add($agente);

        //Role: Admin
        $admin = $auth->createRole('admin');
        $auth->add($admin);


        $auth->addChild($agente, $viajante);

        $auth->addChild($admin, $agente);

        echo "Sucesso! Roles 'viajante', 'agente' e 'admin' criados.\n";
    }

}