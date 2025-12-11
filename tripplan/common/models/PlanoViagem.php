<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plano_viagem".
 *
 * @property int $id
 * @property int $user_id
 * @property string $nome_viagem
 * @property string $data_inicio
 * @property string $data_fim
 *
 * @property FotosMemorias[] $fotosMemorias
 * @property Transporte[] $transportes
 * @property User $user
 */
class PlanoViagem extends \yii\db\ActiveRecord
{

    public $destino_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plano_viagem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'nome_viagem', 'data_inicio', 'data_fim'], 'required', 'message' => 'Este campo é obrigatório.'],
            [['user_id'], 'integer'],
            [['data_inicio', 'data_fim'], 'safe'],
            [['nome_viagem'], 'string', 'max' => 70],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            [['destino_id'], 'safe'], //seguro receber a tabela
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
            'nome_viagem' => 'Nome Viagem',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
        ];
    }

    /**
     * Gets query for [[FotosMemorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFotosMemorias()
    {
        return $this->hasMany(FotosMemorias::class, ['plano_viagem_id' => 'id']);
    }

    /**
     * Gets query for [[Transportes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransportes()
    {
        return $this->hasMany(Transporte::class, ['plano_viagem_id' => 'id']);
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
