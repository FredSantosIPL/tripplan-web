<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "estadia".
 *
 * @property int $id
 * @property int $destino_id
 * @property string $nome_alojamento
 * @property string $tipo
 * @property string $data_checkin
 *
 * @property Destino $destino
 */
class Estadia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destino_id', 'nome_alojamento', 'tipo', 'data_checkin'],'required', 'message' => 'Este campo é obrigatório.'],
            [['destino_id'], 'integer'],
            [['data_checkin'], 'safe'],
            [['nome_alojamento'], 'string', 'max' => 80],
            [['tipo'], 'string', 'max' => 50],
            [['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destino::class, 'targetAttribute' => ['destino_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'destino_id' => 'Destino ID',
            'nome_alojamento' => 'Nome Alojamento',
            'tipo' => 'Tipo',
            'data_checkin' => 'Data Checkin',
        ];
    }

    /**
     * Gets query for [[Destino]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestino()
    {
        return $this->hasOne(Destino::class, ['id' => 'destino_id']);
    }

}
