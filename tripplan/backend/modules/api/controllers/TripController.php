<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use common\models\PlanoViagem;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

/**
 * TripController implementa as ações da API para o modelo PlanoViagem.
 */
class TripController extends ActiveController
{
// Dentro da class TripController extends ActiveController { ...

    public $controllerNamespace = 'backend\modules\api\controllers'; // Força o caminho certo

    // Define a classe do modelo para que o Yii2 crie o CRUD básico automaticamente
    public $modelClass = 'common\models\PlanoViagem';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // Garante que a resposta é sempre JSON
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;

        return $behaviors;
    }

    /**
     * REQUISITO 1.2: Endpoint Personalizado para Master/Detail
     * Rota: GET /api/trips/{id}/details
     * Devolve o PlanoViagem e a lista de Transportes associada.
     */
    public function actionDetails($id)
    {
        // Carrega a Viagem com TODAS as relações
        $plano = PlanoViagem::find()
            ->where(['id' => $id])
            ->with([
                'transportes',     // Relação getTransportes()
                'destinos',        // Relação getDestinos()
                'atividades',      // Relação getAtividades()
                'fotosMemorias',    // Relação getFotosMemorias()
                'estadias',
            ])
            ->asArray()
            ->one();

        if (!$plano) {
            throw new NotFoundHttpException("Plano de viagem não encontrado.");
        }

        return $plano;
    }

    /**
     * Substituímos as ações padrão de Create e Update para adicionar o MQTT.
     */
    public function actions()
    {
        $actions = parent::actions();
        // Removemos o delete padrão para o fazermos à mão
        unset($actions['update'], $actions['create'], $actions['delete']);
        return $actions;
    }

    // Ação Create personalizada com MQTT
    public function actionCreate()
    {
        $model = new PlanoViagem();
        // USAR getBodyParams() em vez de post()
        $model->load(\Yii::$app->request->getBodyParams(), '');

        if ($model->save()) {
            $msg = "Novo plano criado: " . $model->nome_viagem;
            $this->publishMqtt($model->id, $msg);
            return $model;
        }
        return $model; // O Yii2 envia automaticamente o 422 com os erros de validação
    }

    // Ação Update personalizada com MQTT
    public function actionUpdate($id)
    {
        $model = PlanoViagem::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Plano de viagem não encontrado.");
        }

        // USAR getBodyParams() para pedidos PUT/JSON
        $model->load(\Yii::$app->request->getBodyParams(), '');

        if ($model->save()) {
            $msg = "Plano atualizado: " . $model->nome_viagem;
            $this->publishMqtt($model->id, $msg);
            return $model;
        }
        return $model;
    }
    public function actionDelete($id)
    {
        // 1. Procurar a viagem
        $model = \common\models\PlanoViagem::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException("Plano de viagem não encontrado.");
        }

        // 2. Lógica de Apagar em Cascata (Manualmente)

        // A. Primeiro as ATIVIDADES (que estão dentro dos destinos)
        // Vamos buscar os IDs de todos os destinos desta viagem
        $idsDestinos = \common\models\Destino::find()
            ->select('id')
            ->where(['plano_viagem_id' => $id])
            ->column();

        if (!empty($idsDestinos)) {
            // Apaga todas as atividades que pertencem a esses destinos
            \common\models\Atividade::deleteAll(['destino_id' => $idsDestinos]);
        }

        // B. Apagar os DESTINOS da viagem
        \common\models\Destino::deleteAll(['plano_viagem_id' => $id]);

        // C. Apagar os TRANSPORTES da viagem
        \common\models\Transporte::deleteAll(['plano_viagem_id' => $id]);

        // D. Outras relações (Estadias e Fotos)
        // Como vimos no teu Java, também tens estas listas, convém limpar
        \common\models\Estadia::deleteAll(['plano_viagem_id' => $id]);
        \common\models\FotosMemorias::deleteAll(['plano_viagem_id' => $id]);

        // 3. Finalmente, apagar a VIAGEM
        if ($model->delete()) {
            // Enviar notificação MQTT (Opcional)
            $this->publishMqtt($id, "Viagem removida: " . $model->nome_viagem);

            // Responder com 204 (Sucesso sem conteúdo)
            \Yii::$app->response->statusCode = 204;
            return null;
        }

        throw new \yii\web\ServerErrorHttpException("Erro ao apagar a viagem da base de dados.");
    }

    /**
     * Função auxiliar para enviar mensagem MQTT para o broker
     */
    protected function publishMqtt($tripId, $message)
    {
        $server   = 'test.mosquitto.org'; // Confirma se o professor deu outro broker
        $port     = 1883;
        $clientId = 'yii2-app-' . uniqid();

        try {
            $mqtt = new MqttClient($server, $port, $clientId);
            $mqtt->connect();

            // Tópico onde a App Android vai subscrever
            $topic = "viagens/{$tripId}/updates";

            $payload = json_encode([
                'trip_id' => $tripId,
                'nome_viagem' => $message,
                'timestamp' => date('c')
            ]);

            $mqtt->publish($topic, $payload, 0);
            $mqtt->disconnect();
        } catch (\Exception $e) {
            // Log do erro silencioso para não parar a API se a net falhar
            \Yii::error("Erro MQTT: " . $e->getMessage());
        }
    }
}