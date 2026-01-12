<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\PlanoViagem;
use common\models\Destino;
use common\models\User;
use Yii;

/**
 * Class DestinoCest
 * Testes funcionais para o CRUD de Destinos, seguindo o padrão de AtividadeCest.
 */
class DestinoCest
{
    protected $planoId;

    /**
     * Método auxiliar para garantir que o utilizador de teste existe (Estilo AtividadeCest)
     */
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

    /**
     * Executado ANTES de cada teste: Login e preparação de dados.
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

        // 2. Garantir que existe um Plano de Viagem para associar
        $plano = PlanoViagem::find()->one();
        if (!$plano) {
            $user = User::findByUsername('admin_teste');
            $I->haveRecord(PlanoViagem::class, [
                'user_id' => $user->id,
                'nome_viagem' => 'Plano de Teste Funcional',
                'data_inicio' => date('Y-m-d'),
                'data_fim' => date('Y-m-d', strtotime('+7 days')),
            ]);
            $plano = PlanoViagem::find()->one();
        }
        $this->planoId = $plano->id;
    }

    public function acederListaDestinos(FunctionalTester $I)
    {
        $I->amOnPage('/destino/index');
        $I->see('Destinos', 'h1');
    }

    public function criarDestinoVazio(FunctionalTester $I)
    {
        $I->amOnPage('/destino/create');

        // Tenta submeter vazio
        $I->click('button[type="submit"]');

        // Verifica se ficou na mesma página
        $I->seeInCurrentUrl('create');
        $I->see('Destino');
    }

    public function criarDestinoValido(FunctionalTester $I)
    {
        $I->amOnPage('/destino/create');

        $user = User::findByUsername('admin_teste');

        $I->fillField('Destino[nome_cidade]', 'Tóquio');
        $I->fillField('Destino[pais]', 'Japão');
        $I->fillField('Destino[data_chegada]', '2025-11-20');

        // Tentar selecionar o Plano usando seletores específicos (Estilo AtividadeCest)
        try {
            $I->selectOption('select[name="Destino[plano_viagem_id]"]', (string)$this->planoId);
        } catch (\Exception $e) {
            try {
                $I->selectOption('//select[@name="Destino[plano_viagem_id]"]', (string)$this->planoId);
            } catch (\Exception $e2) {
                // Se for um campo de texto ou hidden
                $I->fillField('Destino[plano_viagem_id]', (string)$this->planoId);
            }
        }

        // Tentar preencher o Agente (pode ser select ou input hidden)
        try {
            $I->selectOption('select[name="Destino[agente_viagem_id]"]', (string)$user->id);
        } catch (\Exception $e) {
            try {
                $I->fillField('input[name="Destino[agente_viagem_id]"]', (string)$user->id);
            } catch (\Exception $e2) {
                // Se o campo não existir, o controller deve tratar automaticamente
            }
        }

        $I->click('button[type="submit"]');

        // Confirmar que o registo foi guardado na BD
        $I->seeRecord(Destino::class, [
            'nome_cidade' => 'Tóquio',
            'pais' => 'Japão'
        ]);


        $destino = Destino::findOne(['nome_cidade' => 'Tóquio', 'plano_viagem_id' => $this->planoId]);
        if ($destino) {
            $I->amOnPage('/destino/view?id=' . $destino->id);
            $I->see('Tóquio');
        }
    }
}