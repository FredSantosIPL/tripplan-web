<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plano_destino".
 *
 * @property int $plano_id
 * @property int $destino_id
 *
 * @property PlanoViagem $plano
 * @property Destino $destino
 */
class PlanoDestino extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plano_destino';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // É fundamental que 'plano_id' e 'destino_id' sejam required e integer
            // para que o load() e save() funcionem corretamente sem erros 1364.
            [['plano_id', 'destino_id'], 'required'],
            [['plano_id', 'destino_id'], 'integer'],
            [['plano_id', 'destino_id'], 'unique', 'targetAttribute' => ['plano_id', 'destino_id']],
            [['plano_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlanoViagem::class, 'targetAttribute' => ['plano_id' => 'id']],
            [['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destino::class, 'targetAttribute' => ['destino_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'plano_id' => 'Plano de Viagem',
            'destino_id' => 'Destino',
        ];
    }

    // --- RELAÇÕES NECESSÁRIAS (Correção do erro Unknown Property) ---

    /**
     * Permite aceder a $model->plano
     */
    public function getPlano()
    {
        return $this->hasOne(PlanoViagem::class, ['id' => 'plano_id']);
    }

    /**
     * Permite aceder a $model->destino
     * Corrige o erro na linha: $model->destino->data_chegada
     */
    public function getDestino()
    {
        return $this->hasOne(Destino::class, ['id' => 'destino_id']);
    }
}