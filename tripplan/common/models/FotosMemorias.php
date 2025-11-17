<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fotos_memorias".
 *
 * @property int $id
 * @property int $user_id
 * @property int $plano_viagem_id
 * @property string $comentario
 *
 * @property PlanoViagem $plano-viagem
 * @property User $user
 */
class FotosMemorias extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fotos_memorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'plano_viagem_id', 'comentario'], 'required'],
            [['user_id', 'plano_viagem_id'], 'integer'],
            [['comentario'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'plano_viagem_id' => 'Plano Viagem ID',
            'comentario' => 'Comentario',
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
