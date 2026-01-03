<?php

namespace common\models;

use Yii;
use common\models\Destino;
use common\models\Transporte;
use common\models\FotosMemorias;
use common\models\User;
use common\models\Atividade;

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
 * @property Destino[] $destinos
 * @property Atividade[] $atividades
 */
class PlanoViagem extends \yii\db\ActiveRecord
{
    // Variável auxiliar (opcional, dependendo do uso)
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

            // Validação de datas: data_fim deve ser maior ou igual a data_inicio
            ['data_fim', 'compare', 'compareAttribute' => 'data_inicio', 'operator' => '>=', 'message' => 'A data de fim não pode ser anterior à data de início.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Utilizador',
            'nome_viagem' => 'Nome da Viagem',
            'data_inicio' => 'Data de Início',
            'data_fim' => 'Data de Fim',
        ];
    }

    /**
     * Relação: Uma Viagem tem Muitas Fotos
     */
    public function getFotosMemorias()
    {
        return $this->hasMany(FotosMemorias::class, ['plano_viagem_id' => 'id']);
    }

    /**
     * Relação: Uma Viagem tem Muitos Transportes
     */
    public function getTransportes()
    {
        return $this->hasMany(Transporte::class, ['plano_viagem_id' => 'id']);
    }

    /**
     * Relação: Uma Viagem pertence a um User
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Relação: Uma Viagem tem Muitos Destinos
     */
    public function getDestinos()
    {
        return $this->hasMany(Destino::class, ['plano_viagem_id' => 'id']);
    }

    /**
     * Relação: Uma Viagem tem Muitas Atividades (Indiretas)
     * Como a atividade está ligada ao DESTINO e não à viagem, usamos via('destinos')
     */
    public function getAtividades()
    {
        return $this->hasMany(Atividade::class, ['destino_id' => 'id'])
            ->via('destinos');
    }
}