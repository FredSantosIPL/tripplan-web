<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property int $destino_id
 * @property int $classificacao
 * @property string $comentario
 *
 * @property Destino $destino
 * @property User $utilizador
 */
class Review extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'utilizador_id', 'destino_id', 'classificacao', 'comentario'], 'required'],
            [['id', 'utilizador_id', 'destino_id', 'classificacao'], 'integer'],
            [['comentario'], 'string'],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
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
            'utilizador_id' => 'Utilizador ID',
            'destino_id' => 'Destino ID',
            'classificacao' => 'Classificacao',
            'comentario' => 'Comentario',
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

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }

}
