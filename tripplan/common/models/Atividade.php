<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "atividade".
 *
 * @property int $id
 * @property int $destino_id
 * @property int $plano_viagem_id  <-- Agora é uma propriedade da BD
 * @property string $nome_atividade
 * @property string $tipo
 *
 * @property Destino $destino
 */
class Atividade extends \yii\db\ActiveRecord
{
    // --- REMOVIDO: public $plano_viagem_id; ---
    // Se deixasses aquela linha, o Yii ignorava a coluna da base de dados.

    // Mantemos apenas variáveis que NÃO existem na BD
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

            // CORREÇÃO: Definimos plano_viagem_id como inteiro para gravar na BD
            [['destino_id', 'plano_viagem_id'], 'integer'],

            [['nome_atividade', 'tipo'], 'string', 'max' => 255],

            // Regras de chaves estrangeiras
            [['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destino::class, 'targetAttribute' => ['destino_id' => 'id']],

            // Regra para a variável auxiliar (que não vai para a BD)
            [['cidade_aux'], 'safe'],
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
     * Relações
     */
    public function getDestino()
    {
        return $this->hasOne(Destino::class, ['id' => 'destino_id']);
    }

    // Se quiseres aceder à viagem diretamente
    public function getPlanoViagem()
    {
        return $this->hasOne(PlanoViagem::class, ['id' => 'plano_viagem_id']);
    }
}