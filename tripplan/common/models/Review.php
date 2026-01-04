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
            [['utilizador_id', 'destino_id', 'classificacao', 'comentario'], 'required', 'message' => 'Este campo é obrigatório.'],
            [['utilizador_id', 'destino_id', 'classificacao'], 'integer'],
            [['comentario'], 'string'],

            // Validação da Classificação (1 a 5)
            ['classificacao', 'in', 'range' => [1, 2, 3, 4, 5], 'message' => 'A classificação deve ser entre 1 e 5 estrelas.'],

            [['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destino::class, 'targetAttribute' => ['destino_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'utilizador_id' => 'Utilizador',
            'destino_id' => 'Destino',
            'classificacao' => 'Classificação',
            'comentario' => 'Comentário',
        ];
    }

    /**
     * Relação com Destino
     */
    public function getDestino()
    {
        return $this->hasOne(Destino::class, ['id' => 'destino_id']);
    }

    /**
     * Relação com User (Alterado para usar utilizador_id)
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }
}