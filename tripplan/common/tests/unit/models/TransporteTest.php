<?php

namespace common\tests\unit\models;

use common\models\Transporte;
use common\models\PlanoViagem;
use common\models\User;

class TransporteTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    // Helper: Cria um Plano de Viagem para associar o transporte
    private function getValidPlanoId()
    {
        // 1. User
        $user = User::find()->one();
        if (!$user) {
            $user = new User();
            $user->username = 'tester_trans';
            $user->email = 'trans@test.com';
            $user->status = 10;
            $user->setPassword('123456');
            $user->generateAuthKey();
            $user->save(false);
        }

        // 2. Plano
        $plano = PlanoViagem::find()->one();
        if (!$plano) {
            $plano = new PlanoViagem();
            $plano->user_id = $user->id;
            $plano->nome_viagem = "Plano para Transportes";
            $plano->data_inicio = "2025-10-01";
            $plano->data_fim = "2025-10-10";
            $plano->save(false);
        }
        return $plano->id;
    }

    // TESTE 1: Validar Campos Obrigatórios
    // Garante que o transporte tem dados mínimos (tipo, origem, destino, plano)
    public function testValidarCamposObrigatorios()
    {
        $transporte = new Transporte();

        // Tentar validar vazio
        $this->assertFalse($transporte->validate());

        // Verificar erros
        $this->assertTrue($transporte->hasErrors('tipo'), 'Tipo é obrigatório');
        $this->assertTrue($transporte->hasErrors('origem'), 'Origem é obrigatória');
        $this->assertTrue($transporte->hasErrors('destino'), 'Destino é obrigatório');
        // Se a tua regra no modelo exigir plano_viagem_id, descomenta a linha abaixo:
        // $this->assertTrue($transporte->hasErrors('plano_viagem_id'), 'ID do Plano é obrigatório');
    }

    // TESTE 2: Criar Transporte com Sucesso (Integração)
    public function testCriarTransporteValido()
    {
        $transporte = new Transporte();
        $transporte->plano_viagem_id = $this->getValidPlanoId();
        $transporte->tipo = "Avião";
        $transporte->origem = "Lisboa";
        $transporte->destino = "Londres";
        $transporte->data_partida = "2025-10-02 14:00:00";

        // Tentar gravar
        $this->assertTrue($transporte->save(), "Erro ao gravar transporte: " . json_encode($transporte->getErrors()));

        // Verificar se ficou na BD
        $encontrado = Transporte::findOne(['origem' => "Lisboa", 'destino' => "Londres"]);
        $this->assertNotNull($encontrado, "O transporte Lisboa-Londres deveria estar na BD.");
    }

    // TESTE 3: Testar a Relação (Belongs To PlanoViagem)
    public function testTransportePertenceAPlano()
    {
        // 1. Obter plano válido
        $planoId = $this->getValidPlanoId();
        $planoObj = PlanoViagem::findOne($planoId);

        // 2. Criar transporte ligado a esse plano
        $transporte = new Transporte();
        $transporte->plano_viagem_id = $planoId;
        $transporte->tipo = "Comboio";
        $transporte->origem = "Porto";
        $transporte->destino = "Braga";
        // CORREÇÃO: Adicionar data_partida obrigatória
        $transporte->data_partida = "2025-10-05 09:00:00";

        // CORREÇÃO: Verificar se grava antes de tentar ler
        if (!$transporte->save()) {
            $this->fail("Erro ao gravar transporte Porto-Braga: " . json_encode($transporte->getErrors()));
        }

        // 3. Recuperar da BD e testar a relação
        $transporteGuardado = Transporte::findOne(['origem' => "Porto", 'destino' => "Braga"]);

        // Verifica se encontrou o registo
        $this->assertNotNull($transporteGuardado, "O transporte Porto-Braga não foi encontrado na BD");

        // Verifica se a relação 'planoViagem' devolve o objeto correto
        $this->assertNotNull($transporteGuardado->planoViagem, "A relação 'planoViagem' retornou null");
        $this->assertEquals($planoId, $transporteGuardado->planoViagem->id, "O ID do plano não corresponde");

        // Verifica se o nome do plano bate certo (dinamicamente)
        $this->assertEquals($planoObj->nome_viagem, $transporteGuardado->planoViagem->nome_viagem, "O nome do plano não corresponde");
    }
}