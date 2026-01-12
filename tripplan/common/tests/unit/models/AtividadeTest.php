<?php

namespace common\tests\unit\models;

use common\models\Atividade;
use common\models\Destino;
use common\models\PlanoViagem;
use common\models\User;

class AtividadeTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    private function getValidDestinoId()
    {
        // 1. User
        $user = User::find()->one();
        if (!$user) {
            $user = new User();
            $user->username = 'tester_act';
            $user->email = 'act@test.com';
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
            $plano->nome_viagem = "Plano para Atividades";
            $plano->data_inicio = "2025-05-01";
            $plano->data_fim = "2025-05-05";
            $plano->save(false);
        }

        // 3. Destino (Onde a atividade vai ficar)
        $destino = Destino::find()->where(['plano_viagem_id' => $plano->id])->one();

        if (!$destino) {
            $destino = new Destino();
            $destino->plano_viagem_id = $plano->id;
            $destino->agente_viagem_id = $user->id; // Caso o teu modelo exija
            $destino->nome_cidade = "Madrid";
            $destino->pais = "Espanha";
            $destino->data_chegada = "2025-05-02";
            if (!$destino->save()) {
                $this->fail("Erro ao criar destino auxiliar: " . json_encode($destino->getErrors()));
            }
        }

        return $destino->id;
    }

    // TESTE 1: Validar Campos Obrigatórios
    // Garante que não criamos atividades "órfãs" (sem destino)
    public function testValidarCamposObrigatorios()
    {
        $atividade = new Atividade();

        $this->assertFalse($atividade->validate());

        $this->assertTrue($atividade->hasErrors('nome_atividade'), 'Nome é obrigatório');
        $this->assertTrue($atividade->hasErrors('tipo'), 'Tipo é obrigatório');
        $this->assertTrue($atividade->hasErrors('destino_id'), 'Destino é obrigatório (Atividade pertence a Destino)');
    }

    // TESTE 2: Criar Atividade com Sucesso
    public function testCriarAtividadeValida()
    {
        $atividade = new Atividade();
        $atividade->destino_id = $this->getValidDestinoId();
        $atividade->nome_atividade = "Passeio no Parque";
        $atividade->tipo = "Lazer";
        // $atividade->custo = 0;

        // Tentar gravar
        $this->assertTrue($atividade->save(), "Erro ao gravar atividade: " . json_encode($atividade->getErrors()));

        // Verificar se ficou na BD
        $encontrada = Atividade::findOne(['nome_atividade' => "Passeio no Parque"]);
        $this->assertNotNull($encontrada, "A atividade deveria estar na BD.");
    }

    // TESTE 3: Testar a Relação (Belongs To Destino)
    public function testAtividadePertenceADestino()
    {
        // 1. Criar destino
        $destinoId = $this->getValidDestinoId();
        $destinoObj = Destino::findOne($destinoId);

        // 2. Criar atividade ligada a esse destino
        $atividade = new Atividade();
        $atividade->destino_id = $destinoId;
        $atividade->nome_atividade = "Visita Guiada";
        $atividade->tipo = "Cultura";
        $atividade->save();

        // 3. Recuperar da BD e testar a relação
        $atividadeGuardada = Atividade::findOne(['nome_atividade' => "Visita Guiada"]);

        // Verifica se a relação 'destino' devolve o objeto correto
        $this->assertNotNull($atividadeGuardada->destino, "A relação 'destino' retornou null");
        $this->assertEquals($destinoObj->nome_cidade, $atividadeGuardada->destino->nome_cidade, "A cidade do destino não corresponde");
        $this->assertEquals($destinoId, $atividadeGuardada->destino->id, "O ID do destino não corresponde");
    }
}