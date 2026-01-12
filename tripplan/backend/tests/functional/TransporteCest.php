<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\PlanoViagem;
use common\models\Transporte;
use common\models\User;
use Yii;

/**
 * Class TransporteCest
 * Testes funcionais para o CRUD de Transportes alinhados com o teste unitário.
 */
class TransporteCest
{
    protected $planoId;

    /**
     * Método auxiliar para garantir que o utilizador de teste existe.
     */
    protected function ensureTestUserExists()
    {
        $username = 'admin_teste';
        $user = User::findByUsername($username);

        if (!$user) {
            $user = new User();
            $user->username = $username;
            $user->email = 'admin_teste_trans@tripplan.com';
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

    /**
     * Executado ANTES de cada teste: Login e preparação de Plano de Viagem.
     */
    public function _before(FunctionalTester $I)
    {
        $this->ensureTestUserExists();

        // 1. Login
        $I->amOnPage('/site/login');
        $I->fillField('Username', 'admin_teste');
        $I->fillField('Password', '123456');
        $I->click('button[name="login-button"]');
        $I->see('Sair');

        // 2. Garantir que existe um Plano de Viagem (conforme o teu teste unitário)
        $plano = PlanoViagem::find()->one();
        if (!$plano) {
            $user = User::findByUsername('admin_teste');
            $I->haveRecord(PlanoViagem::class, [
                'user_id' => $user->id,
                'nome_viagem' => 'Plano de Teste Funcional',
                'data_inicio' => date('Y-m-d'),
                'data_fim' => date('Y-m-d', strtotime('+10 days')),
            ]);
            $plano = PlanoViagem::find()->one();
        }
        $this->planoId = $plano->id;
    }

    // TESTE 1: Aceder à listagem
    public function acederListaTransportes(FunctionalTester $I)
    {
        $I->amOnPage('/transporte/index');
        $I->see('Transportes', 'h1');
    }

    // TESTE 2: Tentar criar vazio (Validação)
    public function criarTransporteVazio(FunctionalTester $I)
    {
        $I->amOnPage('/transporte/create');
        $I->click('button[type="submit"]');

        $I->seeInCurrentUrl('create');
        $I->see('Transporte');
    }

    // TESTE 3: Criar um transporte válido (Baseado no teu TransporteTest.php)
    public function criarTransporteValido(FunctionalTester $I)
    {
        $I->amOnPage('/transporte/create');

        // Campos do teu modelo Transporte
        $I->selectOption('Transporte[tipo]', 'Avião');
        $I->fillField('Transporte[origem]', 'Lisboa');
        $I->fillField('Transporte[destino]', 'Londres');
        $I->fillField('Transporte[data_partida]', '2025-10-02 14:00:00');

        // Seleção resiliente do Plano de Viagem
        try {
            $I->selectOption('select[name="Transporte[plano_viagem_id]"]', (string)$this->planoId);
        } catch (\Exception $e) {
            try {
                $I->fillField('input[name="Transporte[plano_viagem_id]"]', (string)$this->planoId);
            } catch (\Exception $e2) {
                // Caso o campo não esteja no form, o controller deve tratar.
            }
        }

        $I->click('button[type="submit"]');

        // 1. Validar na Base de Dados (Esta é a prova real de que o CRUD funcionou)
        $I->seeRecord(Transporte::class, [
            'origem' => 'Lisboa',
            'destino' => 'Londres',
            'tipo' => 'Avião'
        ]);

        // 2. Navegar para a View para confirmar que a página de visualização carrega
        $transporte = Transporte::findOne(['origem' => 'Lisboa', 'destino' => 'Londres']);
        if ($transporte) {
            $I->amOnPage('/transporte/view?id=' . $transporte->id);

            $I->see('Transporte #' . $transporte->id, 'h1');
        }
    }
}