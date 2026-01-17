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
 */
class Atividade extends \yii\db\ActiveRecord
{
    // --- VARIÁVEL VIRTUAL ---
    // Como não existe na BD, criamos aqui para o Controller poder receber o valor do Android
    // antes de descobrir qual é o destino_id.
    public $plano_viagem_id;

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

            // O plano_viagem_id é 'safe' (pode vir do formulário/API) mas não é gravado na BD diretamente
            [['plano_viagem_id'], 'integer'],

            [['nome_atividade', 'tipo'], 'string', 'max' => 255],

            // Chave Estrangeira: Garante que o destino existe mesmo
            [['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destino::class, 'targetAttribute' => ['destino_id' => 'id']],

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
            'tipo' => 'Tipo',
        ];
    }

    /**
     * RELAÇÃO IMPORTANTE
     * Uma atividade pertence a um Destino
     */
    public function getDestino()
    {
        return $this->hasOne(Destino::class, ['id' => 'destino_id']);
    }
}