<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "atividade".
 *
 * @property int $id
 * @property int $destino_id
 * @property string $nome_atividade
 * @property int $tipo
 *
 * @property Destino $destino
 */
class Atividade extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atividade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destino_id', 'nome_atividade', 'tipo'], 'required'],
            [['destino_id'], 'integer'],
            [['nome_atividade', 'tipo'], 'string', 'max' => 255],
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
            'nome_atividade' => 'Nome Atividade',
            'tipo' => 'Tipo',
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
