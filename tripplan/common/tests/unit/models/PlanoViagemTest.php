<?php

namespace common\tests\unit\models;

use common\models\PlanoViagem;
use common\models\User;

class PlanoViagemTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    // Helper para obter um ID de utilizador válido da BD de testes
    private function getValidUserId()
    {
        $user = User::find()->one();

        // CORREÇÃO: Se não existir nenhum user na BD de teste, cria um automaticamente
        if (!$user) {
            $user = new User();
            $user->username = 'user_teste_' . rand(100, 999);
            $user->email = 'teste_' . rand(100, 999) . '@email.com';
            $user->status = 10; // STATUS_ACTIVE
            $user->setPassword('123456');
            $user->generateAuthKey();

            if (!$user->save()) {
                // Se falhar a criação automática, mostra o erro
                $this->fail('Falha crítica: BD vazia e não consegui criar user: ' . json_encode($user->getErrors()));
            }
        }

        return $user->id;
    }

    // TESTE 1: Validar campos obrigatórios (Input Validation)
    public function testValidarCamposObrigatorios()
    {
        $plano = new PlanoViagem();

        // Tentar validar sem preencher nada
        $this->assertFalse($plano->validate());

        // Verificar se existem erros nos campos específicos
        $this->assertTrue($plano->hasErrors('nome_viagem'));
        $this->assertTrue($plano->hasErrors('data_inicio'));
        $this->assertTrue($plano->hasErrors('data_fim'));
        $this->assertTrue($plano->hasErrors('user_id'));
    }

    // TESTE 2: Validar tipos de dados (user_id deve ser inteiro)
    public function testValidarTipoDados()
    {
        $plano = new PlanoViagem();
        $plano->user_id = "uma string"; // Inválido
        $plano->nome_viagem = "Teste";
        $plano->data_inicio = "2025-01-01";
        $plano->data_fim = "2025-01-05";

        $this->assertFalse($plano->validate(['user_id']));
    }

    // TESTE 3: Validar Lógica de Datas (Data Fim >= Data Inicio)
    public function testValidarDatasLogica()
    {
        $plano = new PlanoViagem();
        $plano->user_id = $this->getValidUserId(); // Usa ID válido (existente ou criado agora)
        $plano->nome_viagem = "Viagem no Tempo Errada";
        $plano->data_inicio = "2025-12-31";
        $plano->data_fim = "2025-01-01"; // Data fim ANTES do inicio

        $this->assertFalse($plano->validate());
        $this->assertTrue($plano->hasErrors('data_fim'));

        // Corrigir para data válida
        $plano->data_fim = "2026-01-01";
        // Agora deve passar (se falhar aqui, o assert mostra os erros)
        $this->assertTrue($plano->validate(['data_fim']), "Erro na data: " . json_encode($plano->getErrors()));
    }

    // TESTE 4: Teste de Integração BD - Criar Registo (Save)
    public function testCriarPlanoComSucesso()
    {
        $plano = new PlanoViagem();
        $plano->user_id = $this->getValidUserId(); // Usa ID válido dinâmico
        $plano->nome_viagem = "Viagem de Teste Unitário";
        $plano->data_inicio = "2025-06-01";
        $plano->data_fim = "2025-06-10";

        // Tentar gravar - Adicionada mensagem de erro para debug
        $this->assertTrue($plano->save(), "Falha ao gravar Plano: " . json_encode($plano->getErrors()));

        // Verificar se está mesmo na BD (Substitui o seeRecord por findOne)
        $registo = PlanoViagem::findOne(['nome_viagem' => "Viagem de Teste Unitário"]);
        $this->assertNotNull($registo, "O registo deveria existir na base de dados.");
    }

    // TESTE 5: Teste de Integração BD - Editar Registo (Update)
    public function testAtualizarPlano()
    {
        // 1. Criar
        $plano = new PlanoViagem();
        $plano->user_id = $this->getValidUserId(); // Usa ID válido dinâmico
        $plano->nome_viagem = "Original";
        $plano->data_inicio = "2025-06-01";
        $plano->data_fim = "2025-06-10";
        $plano->save();

        // 2. Procurar e Editar
        $planoGuardado = PlanoViagem::findOne(['nome_viagem' => 'Original']);
        $planoGuardado->nome_viagem = "Alterado";

        // 3. Verificar
        $this->assertTrue($planoGuardado->save(), "Falha ao atualizar Plano: " . json_encode($planoGuardado->getErrors()));

        // Verificar que o novo existe
        $this->assertNotNull(PlanoViagem::findOne(['nome_viagem' => "Alterado"]), "O registo atualizado devia existir.");

        // Verificar que o antigo já não existe
        $this->assertNull(PlanoViagem::findOne(['nome_viagem' => "Original"]), "O nome antigo ainda existe na BD.");
    }
}