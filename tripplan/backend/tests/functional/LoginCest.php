<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\User;
use Yii;

/**
 * Class LoginCest
 */
class LoginCest
{
    // Método auxiliar para criar um utilizador de teste limpo COM PERMISSÕES
    protected function ensureTestUserExists()
    {
        $username = 'admin_teste';
        $user = User::findByUsername($username);

        if (!$user) {
            $user = new User();
            $user->username = $username;
            $user->email = 'admin_teste@tripplan.com';
            $user->status = 10; // STATUS_ACTIVE
        }

        // Força a password e chaves de segurança
        $user->setPassword('123456');
        $user->generateAuthKey();

        if (!$user->save(false)) {
            throw new \Exception("Falha crítica ao criar utilizador de teste: " . print_r($user->getErrors(), true));
        }

        // --- CORREÇÃO RBAC: Atribuir Role 'admin' ao utilizador ---
        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin'); // Procura a role 'admin' que criaste no RbacController

        if ($adminRole) {
            // Verifica se já tem a role para não dar erro de duplicado
            if (!$auth->getAssignment('admin', $user->id)) {
                $auth->assign($adminRole, $user->id);
            }
        }
        // ----------------------------------------------------------

        return $user;
    }

    // TESTE 1: Login com password errada
    public function loginComPasswordErrada(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');

        $I->fillField('Username', 'admin');
        $I->fillField('Password', 'password_errada_123');

        // Usa o nome do botão definido no teu formulário (name='login-button')
        $I->click('button[name="login-button"]');

        $I->see('Incorrect username or password.');
    }

    // TESTE 2: Login com sucesso
    public function loginComSucesso(FunctionalTester $I)
    {
        $this->ensureTestUserExists(); // Garante que 'admin_teste' existe E TEM PERMISSÃO

        $I->amOnPage('/site/login');

        // Usamos as credenciais do utilizador que acabámos de garantir que existe
        $I->fillField('Username', 'admin_teste');
        $I->fillField('Password', '123456');

        // Clicar no botão de submit específico
        $I->click('button[name="login-button"]');

        // Se passar, não deve ver erro e deve ver o botão Sair
        $I->dontSee('Incorrect username or password.');
        $I->see('Sair');
    }
}