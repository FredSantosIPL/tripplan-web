<?php

use yii\db\Migration;
use common\models\User;

class m251030_210950_create_admin_user extends Migration
{
    public function safeUp()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@tripplan.com'; // Pode ser um email fictício
        $user->status = User::STATUS_ACTIVE; // Define o utilizador como ativo
        $user->setPassword('admin123'); // Define a password
        $user->generateAuthKey();
        $user->generateEmailVerificationToken(); // Pode gerar mesmo que não use

        // Tenta guardar o utilizador
        if ($user->save()) {
            echo "Utilizador admin criado com ID: " . $user->id . "\n";

            // Agora, atribui o role 'admin'
            $auth = Yii::$app->authManager;
            $adminRole = $auth->getRole('admin');

            if ($adminRole) {
                $auth->assign($adminRole, $user->getId());
                echo "Role 'admin' atribuído ao utilizador " . $user->id . "\n";
            } else {
                echo "ERRO: Role 'admin' não encontrado.\n";
                return false;
            }
        } else {
            echo "ERRO: Não foi possível guardar o utilizador admin.\n";
            // Mostrar erros de validação
            foreach ($user->getErrors() as $key => $errors) {
                echo "  - $key: " . implode(", ", $errors) . "\n";
            }
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Encontrar o utilizador
        $user = User::findOne(['username' => 'admin']);

        if ($user) {
            // 1. Remover a atribuição do role
            $auth = Yii::$app->authManager;
            $adminRole = $auth->getRole('admin');
            if ($adminRole) {
                $auth->revoke($adminRole, $user->id);
                echo "Role 'admin' removido do utilizador " . $user->id . "\n";
            }

            // 2. Apagar o utilizador
            $user->delete();
            echo "Utilizador 'admin' apagado.\n";
        } else {
            echo "Utilizador 'admin' não encontrado. Nada a fazer.\n";
        }

        return true;
    }
}
