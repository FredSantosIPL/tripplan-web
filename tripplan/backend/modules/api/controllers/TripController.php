<?php

namespace app\modules\api\controllers;

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
                'fotosMemorias'    // Relação getFotosMemorias()
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
        unset($actions['update'], $actions['create']);
        return $actions;
    }

    // Ação Create personalizada com MQTT
    public function actionCreate()
    {
        $model = new PlanoViagem();

        // Carrega os dados do POST
        $model->load(\Yii::$app->request->post(), '');

        if ($model->save()) {
            // REQUISITO 2: Messaging
            // Usa 'nome_viagem' conforme o teu modelo
            $msg = "Novo plano criado: " . $model->nome_viagem;
            $this->publishMqtt($model->id, $msg);

            return $model;
        } elseif (!$model->hasErrors()) {
            throw new \yii\web\ServerErrorHttpException('Falha ao criar o objeto por razões desconhecidas.');
        }

        return $model;
    }

    // Ação Update personalizada com MQTT
    public function actionUpdate($id)
    {
        $model = PlanoViagem::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Plano de viagem não encontrado.");
        }

        $model->load(\Yii::$app->request->post(), '');

        if ($model->save()) {
            // REQUISITO 2: Messaging
            $msg = "Plano atualizado: " . $model->nome_viagem;
            $this->publishMqtt($model->id, $msg);

            return $model;
        } elseif (!$model->hasErrors()) {
            throw new \yii\web\ServerErrorHttpException('Falha ao atualizar o objeto.');
        }

        return $model;
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