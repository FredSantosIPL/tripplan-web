<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "atividade".
 *
 * @property int $id
 * @property int $destino_id
 * @property string $nome_atividade
 * @property string $tipo
 *
 * @property Destino $destino
 * @property PlanoViagem $planoViagem
 */
class Atividade extends \yii\db\ActiveRecord
{

    public $cidade_aux;

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
            [['destino_id', 'nome_atividade', 'tipo'], 'required', 'message' => 'Este campo é obrigatório.'],
            [['destino_id'], 'integer'],
            [['nome_atividade', 'tipo'], 'string', 'max' => 255],
            [['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destino::class, 'targetAttribute' => ['destino_id' => 'id']],

            // ADICIONADO: Regra 'safe' para permitir carregar o plano_viagem_id no form
            [['plano_viagem_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'destino_id' => 'Destino',
            'nome_atividade' => 'Nome da Atividade',
            'tipo' => 'Tipo de Atividade',
            'plano_viagem_id' => 'Plano de Viagem',
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
     * ADICIONADO: Relação auxiliar para obter o plano de viagem através do destino.
     * Isto permite fazer $atividade->planoViagem->nome_viagem
     */
    public function getPlanoViagem()
    {
        return $this->hasOne(PlanoViagem::class, ['id' => 'plano_viagem_id'])
            ->via('destino');
    }
}