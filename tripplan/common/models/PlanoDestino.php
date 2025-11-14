<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plano_destino".
 *
 * @property int $plano_id
 * @property int $destino_id
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
            [['destino_id'], 'required'],
            [['destino_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'plano_id' => 'Plano ID',
            'destino_id' => 'Destino ID',
        ];
    }

}
