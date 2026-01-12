<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\User;
use Yii;

/**
 * Class AtividadeCest
 */
class AtividadeCest
{
    // Método auxiliar para garantir que o utilizador de teste existe
    protected function ensureTestUserExists()
    {
        $username = 'admin_teste';
        $user = User::findByUsername($username);

        if (!$user) {
            $user = new User();
            $user->username = $username;
            $user->email = 'admin_teste@tripplan.com';
            $user->status = 10; // STATUS_ACTIVE
            $user->setPassword('123456');
            $user->generateAuthKey();
            $user->save(false);

            $auth = Yii::$app->authManager;
            $role = $auth->getRole('admin');
            if ($role) {
                $auth->assign($role, $user->id);
            }
        }
    }

    public function _before(FunctionalTester $I)
    {
        $this->ensureTestUserExists();
        $I->amOnPage('/site/login');
        $I->fillField('Username', 'admin_teste');
        $I->fillField('Password', '123456');
        $I->click('button[name="login-button"]');
        $I->see('Sair');
    }

    public function acederCriarAtividade(FunctionalTester $I)
    {
        $I->amOnPage('/atividade/create');
        // Se a página carregar, deve ter este título ou parte dele
        $I->see('Atividade');
    }

    public function criarAtividadeVazia(FunctionalTester $I)
    {
        $I->amOnPage('/atividade/create');

        // Tenta submeter vazio
        $I->click('button[type="submit"]');

        // Verifica se ficou na mesma página (URL continua a ter 'create')
        $I->seeInCurrentUrl('create');

        // Verifica se o título do formulário ainda está lá (prova que não saiu da página)
        $I->see('Atividade');
    }

    public function criarAtividadeValida(FunctionalTester $I)
    {
        $I->amOnPage('/atividade/create');

        $I->fillField('Atividade[nome_atividade]', 'Visita ao Museu do Prado');

        // Seleciona o tipo
        $I->selectOption('Atividade[tipo]', 'Cultura');


        try {

            $I->selectOption('form select[name="Atividade[destino_id]"]', '32');
        } catch (\Exception $e) {

        }

        // Se o plano_viagem_id for obrigatório no formulário (dropdown visível):
        try {
            $I->selectOption('//select[@name="Atividade[plano_viagem_id]"]', '32');
        } catch (\Exception $e) {}


        $I->click('button[type="submit"]');

        $I->see('Visita ao Museu do Prado');
    }
}