<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PlanoViagem;

/**
 * PlanoViagemSearch represents the model behind the search form of `common\models\PlanoViagem`.
 */
class PlanoViagemSearch extends PlanoViagem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['nome_viagem', 'data_inicio', 'data_fim'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = PlanoViagem::find();

//        if (!\Yii::$app->user->isGuest) {
//            $query->andWhere(['user_id' => \Yii::$app->user->id]);
//        } else {
//            // Se não estiver logado, esconde tudo (segurança)
//            $query->where('0=1');
//        }
//        // add conditions that should always apply here
//
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
        ]);

        $query->andFilterWhere(['like', 'nome_viagem', $this->nome_viagem]);

        return $dataProvider;
    }
}
