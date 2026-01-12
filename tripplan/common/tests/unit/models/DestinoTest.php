<?php

namespace common\tests\unit\models;

use common\models\Destino;
use common\models\PlanoViagem;
use common\models\User;

class DestinoTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    // Helper para garantir que temos um ID de plano válido para associar
    private function getValidPlanoId()
    {
        // 1. Garantir User
        $user = User::find()->one();
        if (!$user) {
            $user = new User();
            $user->username = 'tester_unit';
            $user->email = 'tester@unit.com';
            $user->status = 10;
            $user->setPassword('123456');
            $user->generateAuthKey();
            $user->save(false);
        }

        // 2. Garantir Plano
        // Tenta encontrar um plano existente
        $plano = PlanoViagem::find()->one();

        // Se não existir, cria um novo
        if (!$plano) {
            $plano = new PlanoViagem();
            $plano->user_id = $user->id;
            $plano->nome_viagem = "Plano Base Unitário";
            $plano->data_inicio = "2025-01-01";
            $plano->data_fim = "2025-01-10";
            $plano->save(false);
        }
        return $plano->id;
    }

    // Helper para garantir um ID de Agente (User) válido
    private function getValidAgenteId()
    {
        $user = User::findByUsername('tester_unit');
        if ($user) return $user->id;

        $user = User::find()->one();
        return $user ? $user->id : 1;
    }

    // TESTE 1: Validar campos obrigatórios
    public function testValidarCamposObrigatorios()
    {
        $destino = new Destino();

        // Tentar validar vazio
        $this->assertFalse($destino->validate());

        // Verificar erros nos campos required
        $this->assertTrue($destino->hasErrors('nome_cidade'), 'Cidade devia ser obrigatória');
        $this->assertTrue($destino->hasErrors('pais'), 'País devia ser obrigatório');
        $this->assertTrue($destino->hasErrors('data_chegada'), 'Data Chegada devia ser obrigatória');
        $this->assertTrue($destino->hasErrors('agente_viagem_id'), 'ID do Agente devia ser obrigatório');
    }

    // TESTE 2: Validar tipos de dados (IDs devem ser inteiros)
    public function testValidarTiposDados()
    {
        $destino = new Destino();
        $destino->nome_cidade = "Porto";
        $destino->pais = "Portugal";
        $destino->data_chegada = "2025-07-01";

        // Teste de falha: ID como string de texto
        $destino->plano_viagem_id = "texto-invalido";

        $this->assertFalse($destino->validate(['plano_viagem_id']));
    }

    // TESTE 3: Criar Destino com sucesso (Integração BD)
    public function testCriarDestinoValido()
    {
        $destino = new Destino();
        $destino->plano_viagem_id = $this->getValidPlanoId();
        $destino->agente_viagem_id = $this->getValidAgenteId(); // Adicionado agente_viagem_id
        $destino->nome_cidade = "Paris";
        $destino->pais = "França";
        $destino->data_chegada = "2025-08-01";
        // $destino->descricao = "Cidade Luz"; // Removido se não existir na BD

        // Tentar gravar
        $this->assertTrue($destino->save(), "Erro ao gravar destino: " . json_encode($destino->getErrors()));

        // Verificar se está na BD (Substituído seeRecord por findOne)
        $registo = Destino::findOne(['nome_cidade' => "Paris", 'pais' => "França"]);
        $this->assertNotNull($registo, "O destino 'Paris' deveria ter sido gravado na BD.");
    }

    // TESTE 4: Verificar se o Destino pertence a um Plano de Viagem (Relação)
    public function testDestinoPertenceAPlano()
    {
        // 1. Obter um plano válido
        $planoId = $this->getValidPlanoId();

        // CORREÇÃO: Obter o objeto Plano real para comparar o nome dinamicamente
        $planoReal = PlanoViagem::findOne($planoId);

        // 2. Criar um destino associado a esse plano
        $destino = new Destino();
        $destino->plano_viagem_id = $planoId;
        $destino->agente_viagem_id = $this->getValidAgenteId();
        $destino->nome_cidade = "Roma";
        $destino->pais = "Itália";
        $destino->data_chegada = "2025-09-01";

        // Tentar gravar e mostrar erro se falhar
        if (!$destino->save()) {
            $this->fail("Erro ao gravar destino Roma: " . json_encode($destino->getErrors()));
        }

        // 3. Verificar a relação via código
        $destinoGuardado = Destino::findOne(['nome_cidade' => 'Roma']);

        $this->assertNotNull($destinoGuardado, "O destino não foi encontrado na BD");
        $this->assertNotNull($destinoGuardado->planoViagem, "A relação 'planoViagem' retornou null");
        $this->assertEquals($planoId, $destinoGuardado->planoViagem->id, "O ID do plano relacionado não corresponde");

        // CORREÇÃO: Comparar com o nome que está na BD, seja ele qual for ("Plano Base..." ou "ibiza")
        $this->assertEquals($planoReal->nome_viagem, $destinoGuardado->planoViagem->nome_viagem);
    }
}