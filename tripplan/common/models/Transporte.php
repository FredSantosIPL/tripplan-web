<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transporte".
 *
 * @property int $id
 * @property int $plano_viagem_id
 * @property string $tipo
 * @property string $origem
 * @property string $destino
 * @property string $data_partida
 *
 * @property PlanoViagem $planoViagem
 */
class Transporte extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transporte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plano_viagem_id', 'tipo', 'origem', 'destino', 'data_partida'], 'required'],
            [['plano_viagem_id'], 'integer'],
            [['data_partida'], 'safe'],
            [['tipo'], 'string', 'max' => 30],
            [['origem', 'destino'], 'string', 'max' => 60],
            [['plano_viagem_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlanoViagem::class, 'targetAttribute' => ['plano_viagem_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plano_viagem_id' => 'Plano Viagem ID',
            'tipo' => 'Tipo',
            'origem' => 'Origem',
            'destino' => 'Destino',
            'data_partida' => 'Data Partida',
        ];
    }

    /**
     * Gets query for [[PlanoViagem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlanoViagem()
    {
        return $this->hasOne(PlanoViagem::class, ['id' => 'plano_viagem_id']);
    }

}
