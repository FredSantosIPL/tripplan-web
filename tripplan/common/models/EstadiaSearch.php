<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Estadia;

/**
 * EstadiaSearch represents the model behind the search form of `common\models\Estadia`.
 */
class EstadiaSearch extends Estadia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'destino_id'], 'integer'],
            [['nome_alojamento', 'tipo', 'data_checkin'], 'safe'],
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
        $query = Estadia::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'destino_id' => $this->destino_id,
            'data_checkin' => $this->data_checkin,
        ]);

        $query->andFilterWhere(['like', 'nome_alojamento', $this->nome_alojamento])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }
}
