<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\PlanoDestino;
use common\models\Destino;
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

    public function afterSave($insert, $changedAttributes)
    {
        // Executa o comportamento padrão primeiro
        parent::afterSave($insert, $changedAttributes);

        // Se o utilizador selecionou um destino no formulário
        if (!empty($this->destino_id)) {

            // Passo 1: Se estivermos a editar, apagamos o destino antigo para não duplicar
            PlanoDestino::deleteAll(['plano_id' => $this->id]);

            // Passo 2: Criamos a nova ligação
            $novaLigacao = new PlanoDestino();
            $novaLigacao->plano_id = $this->id; // ID desta viagem
            $novaLigacao->destino_id = $this->destino_id; // ID do destino escolhido
            $novaLigacao->save();
        }
    }


    public function getPlanoDestinos()
    {
        // Certifica-te que tens o ficheiro common/models/PlanoDestino.php criado!
        return $this->hasMany(PlanoDestino::class, ['plano_id' => 'id']);
    }

    /**
     * Passo 2: Ligar aos Destinos finais.
     * O "via" diz para usar a relação de cima para chegar aos destinos.
     */
    public function getDestinos()
    {
        return $this->hasMany(Destino::class, ['plano_viagem_id' => 'id']);
    }

    public function extraFields()
    {
        return ['destinos', 'estadias', 'transportes'];
    }

    /**
     * Relação: Uma Viagem tem Muitas Atividades (Indiretas)
     * Como a atividade está ligada ao DESTINO e não à viagem, usamos via('destinos')
     */
    public function getAtividades()
    {
        return $this->hasMany(Atividade::class, ['plano_viagem_id' => 'id'])
            ->via('destinos');
    }


    public function getEstadias()
    {
        return $this->hasMany(Estadia::class, ['plano_viagem_id' => 'id']);
    }

}
