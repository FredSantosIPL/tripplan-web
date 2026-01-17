<?php

namespace common\models;
use common\models\PlanoViagem;
use Yii;

/**
 * This is the model class for table "favorito".
 *
 * @property int $id
 * @property int $user_id
 * @property int $destino_id
 * @property string $created_at
 *
 * @property User $user
 * @property Destino $destino
 */
class Favorito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'destino_id'], 'required'],
            [['user_id', 'destino_id'], 'integer'],
            [['created_at'], 'safe'],

            // Garante que não se pode adicionar o mesmo favorito duas vezes
            [['user_id', 'destino_id'], 'unique', 'targetAttribute' => ['user_id', 'destino_id']],

            // Valida se o utilizador existe
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            // Valida se o destino existe (CRUCIAL)
            //[['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destino::class, 'targetAttribute' => ['destino_id' => 'id']],
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
            'destino_id' => 'Destino ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    // --- ADICIONADO: Alias para manter compatibilidade se usar $favorito->utilizador noutro lugar ---
    public function getUtilizador()
    {
        return $this->getUser();
    }

    /**
     * Gets query for [[Destino]].
     * CORREÇÃO DO ERRO: Permite aceder a $favorito->destino
     * @return \yii\db\ActiveQuery
     */
    public function getDestino()
    {
        return $this->hasOne(Destino::class, ['id' => 'destino_id']);
    }


    // No teu Favorito.php
    public function fields()
    {
        // Campos base que vão sempre
        return ['id', 'user_id', 'destino_id'];
    }

    public function extraFields()
    {
        // Permite que o Android peça ?expand=viagem
        return ['viagem'];
    }

    // A relação que o Android vai "expandir"
    public function getViagem()
    {
        // Aqui usamos a relação com o model Destino (onde tens o nome da viagem)
        return $this->hasOne(PlanoViagem::class, ['id' => 'destino_id']);
    }
}