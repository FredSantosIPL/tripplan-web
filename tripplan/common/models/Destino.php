<?php

namespace common\models;

use Yii;
use common\models\Atividade;

/**
 * This is the model class for table "destino".
 *
 * @property int $id
 * @property int $agente_viagem_id
 * @property string $nome_cidade
 * @property string $pais
 * @property string $data_chegada
 *
 * @property User $agenteViagem
 * @property Atividade[] $atividades
 * @property Despesa[] $despesas
 * @property Estadia[] $estadias
 * @property Review[] $reviews
 */
class Destino extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'destino';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plano_viagem_id', 'agente_viagem_id'], 'integer'],
            [['agente_viagem_id', 'nome_cidade', 'pais', 'data_chegada'], 'required', 'message' => 'Este campo é obrigatório.'],
            [['agente_viagem_id'], 'integer'],
            [['data_chegada'], 'safe'],
            [['nome_cidade', 'pais'], 'string', 'max' => 50],
            [['agente_viagem_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['agente_viagem_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agente_viagem_id' => 'Agente Viagem ID',
            'nome_cidade' => 'Nome Cidade',
            'pais' => 'Pais',
            'data_chegada' => 'Data Chegada',
        ];
    }

    /**
     * Gets query for [[AgenteViagem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgenteViagem()
    {
        return $this->hasOne(User::class, ['id' => 'agente_viagem_id']);
    }

    /**
     * Gets query for [[Atividades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtividades()
    {
        return $this->hasMany(Atividade::class, ['destino_id' => 'id']);
    }

    /**
     * Gets query for [[Estadias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstadias()
    {
        return $this->hasMany(Estadia::class, ['destino_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['destino_id' => 'id']);
    }

    /**
     * Define a relação com o Plano de Viagem
     */
    public function getPlanoViagem()
    {
        return $this->hasOne(PlanoViagem::class, ['id' => 'plano_viagem_id']);
    }
}
