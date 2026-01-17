<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\PlanoDestino;
use common\models\Destino;
use common\models\Atividade;     // <--- Importante adicionar isto!
use common\models\FotosMemorias; // <--- E isto!
use common\models\Transporte;    // <--- E isto!
use common\models\Estadia;       // <--- E isto!

/**
 * This is the model class for table "plano_viagem".
 * ...
 */
class PlanoViagem extends \yii\db\ActiveRecord
{
    public $destino_id;

    public static function tableName()
    {
        return 'plano_viagem';
    }

    public function rules()
    {
        return [
            [['user_id', 'nome_viagem', 'data_inicio', 'data_fim'], 'required', 'message' => 'Este campo é obrigatório.'],
            [['user_id'], 'integer'],
            [['data_inicio', 'data_fim'], 'safe'],
            [['nome_viagem'], 'string', 'max' => 70],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['destino_id'], 'safe'],
            ['data_fim', 'compare', 'compareAttribute' => 'data_inicio', 'operator' => '>=', 'message' => 'A data de fim não pode ser anterior à data de início.'],
        ];
    }

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

    // --- RELAÇÕES DIRETAS ---

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getFotosMemorias()
    {
        return $this->hasMany(FotosMemorias::class, ['plano_viagem_id' => 'id']);
    }

    public function getTransportes()
    {
        return $this->hasMany(Transporte::class, ['plano_viagem_id' => 'id']);
    }

    public function getEstadias()
    {
        // Se a tua tabela 'estadia' tem 'plano_viagem_id', isto está correto.
        return $this->hasMany(Estadia::class, ['plano_viagem_id' => 'id']);
    }

    public function getDestinos()
    {
        // Relação direta (1 Viagem -> N Destinos)
        return $this->hasMany(Destino::class, ['plano_viagem_id' => 'id']);
    }

    // --- RELAÇÕES INDIRETAS (VIA) ---

    /**
     * CORREÇÃO AQUI:
     * 1. Usamos via('destinos') porque a atividade pertence ao destino.
     * 2. No hasMany, o primeiro argumento é a Atividade.
     * 3. O array ['destino_id' => 'id'] significa:
     * "Procura na tabela Atividade onde a coluna 'destino_id' é igual ao 'id' do Destino encontrado".
     */
    public function getAtividades()
    {
        return $this->hasMany(Atividade::class, ['destino_id' => 'id'])
            ->via('destinos');
    }

    // --- CONFIGURAÇÃO DA API ---

    public function extraFields()
    {
        // CORREÇÃO AQUI: Adicionei 'atividades' e 'fotosMemorias'
        // Sem isto, a API ignora o ?expand=atividades
        return [
            'destinos',
            'estadias',
            'transportes',
            'atividades',
            'fotosMemorias'
        ];
    }

    // --- LÓGICA DE INTERFACE WEB (LEGADO) ---
    // Mantive isto caso estejas a usar no backend web, mas para a API não afeta muito.

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!empty($this->destino_id)) {
            PlanoDestino::deleteAll(['plano_id' => $this->id]);
            $novaLigacao = new PlanoDestino();
            $novaLigacao->plano_id = $this->id;
            $novaLigacao->destino_id = $this->destino_id;
            $novaLigacao->save();
        }
    }

    public function getPlanoDestinos()
    {
        return $this->hasMany(PlanoDestino::class, ['plano_id' => 'id']);
    }
}