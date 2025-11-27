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

        // Permissões

        $acederBackoffice = $auth->createPermission('acederBackofficeAgente');
        $acederBackoffice->description = 'Acessar backoffice';
        $auth->add($acederBackoffice);

        $gerirDestinos = $auth->createPermission('gerirDestinos');
        $gerirDestinos->description = 'Gerir destinos';
        $auth->add($gerirDestinos);

        //Role: Viajante
        $viajante = $auth->createRole('viajante');
        $auth->add($viajante);

        //Role: Agente
        $agente = $auth->createRole('agente');
        $auth->add($agente);

        $auth->addChild($agente, $acederBackoffice);
        $auth->addChild($agente, $gerirDestinos);

        $auth->addChild($agente, $viajante);

        //Role: Admin
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin, $agente);

        try {
            $auth->assign($admin, 8);
        }catch (\Exception $exception){
            echo "Não foi possível atribuir ao ID 1";
        }
    }

}