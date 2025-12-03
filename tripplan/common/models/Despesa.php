<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "despesa".
 *
 * @property int $id
 * @property int $destino_id
 * @property string $descricao
 * @property float $valor
 *
 * @property Destino $destino
 */
class Despesa extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'despesa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destino_id'], 'required'],
            [['destino_id'], 'integer'],
            [['valor'], 'number'],
            [['descricao'], 'string', 'max' => 200],
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
            'descricao' => 'Descricao',
            'valor' => 'Valor (€)',
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
