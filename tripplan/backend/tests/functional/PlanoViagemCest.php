<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\User;
use Yii;

/**
 * Class PlanoViagemCest
 */
class PlanoViagemCest
{
    // Método auxiliar (Igual ao LoginCest) para garantir que o user existe e tem permissões
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

        $user->setPassword('123456');
        $user->generateAuthKey();
        $user->save(false);

        // Atribuir Role 'admin' para ter acesso ao backoffice
        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');

        if ($adminRole && !$auth->getAssignment('admin', $user->id)) {
            $auth->assign($adminRole, $user->id);
        }
    }

    // Executado ANTES de cada teste: Fazer Login
    public function _before(FunctionalTester $I)
    {
        // 1. Garantir user e permissões
        $this->ensureTestUserExists();

        // 2. Fazer Login
        $I->amOnPage('/site/login');
        $I->fillField('Username', 'admin_teste');
        $I->fillField('Password', '123456');

        // Clicar no botão correto
        $I->click('button[name="login-button"]');
    }

    // TESTE 3: Aceder à lista de viagens (Index)
    public function acederListaViagens(FunctionalTester $I)
    {
        $I->amOnPage('/plano-viagem/index');

        // Verifica se vê o título da página
        $I->see('Planos de Viagem', 'h1');
    }

    // TESTE 4: Tentar criar viagem vazia (Testar Validação)
    public function criarViagemVazia(FunctionalTester $I)
    {
        $I->amOnPage('/plano-viagem/create');

        // Tenta guardar sem preencher nada
        $I->click('button[type="submit"]');

        // CORREÇÃO: Em vez de procurar uma mensagem de erro específica (que muda com a língua),
        // verificamos se o sistema nos manteve na página de criação (URL contém 'create').
        // Se a validação funcionou, não fomos redirecionados para o 'view'.
        $I->seeInCurrentUrl('create');

        // Verifica se ainda vemos o título da página (prova que o form ainda está lá)
        // Alterado de 'Dados da Viagem' para 'Create Plano Viagem' (ou 'Adicionar Plano') conforme o log de erro
        $I->see('Create Plano Viagem');
    }

    // TESTE 5: Criar uma viagem com sucesso
    public function criarViagemValida(FunctionalTester $I)
    {
        $I->amOnPage('/plano-viagem/create');

        // Preenche o formulário
        $I->fillField('PlanoViagem[nome_viagem]', 'Viagem Funcional Teste');
        $I->fillField('PlanoViagem[data_inicio]', '2025-08-01');
        $I->fillField('PlanoViagem[data_fim]', '2025-08-15');

        $I->click('button[type="submit"]');

        // Após guardar, deve ir para a página de detalhes
        // Verificamos apenas o NOME, que não sofre alterações de formatação de data
        $I->see('Viagem Funcional Teste');
    }
}