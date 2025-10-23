<?php

use yii\db\Migration;

class m251023_220202_init_rbac extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // 1. Criar o role "viajante" (utilizador normal)
        $viajante = $auth->createRole('viajante');
        $viajante->description = 'Utilizador registado que pode planear viagens';
        $auth->add($viajante);

        // 2. Criar o role "admin"
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrador com acesso total ao back-office';
        $auth->add($admin);

        // 3. Fazer com que o admin "herde" as permissões do viajante
        // (Isto é útil caso queira que o admin também possa fazer o que o viajante faz)
        $auth->addChild($admin, $viajante);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->remove($auth->getRole('admin'));
        $auth->remove($auth->getRole('viajante'));
    }
}
