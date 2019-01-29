<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlanReceiving;

/**
 * PlanReceivingSearch represents the model behind the search form of `app\models\PlanReceiving`.
 */
class PlanReceivingSearch extends PlanReceiving
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'flag'], 'integer'],
            [['vendor_name', 'vehicle', 'item_type', 'receiving_date', 'month_periode', 'container_no', 'urgent_status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PlanReceiving::find()->where([
            'flag' => 1
        ]);

        // add conditions that should always apply here

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
            'qty' => $this->qty,
            'receiving_date' => $this->receiving_date,
            'flag' => $this->flag,
            'urgent_status' => $this->urgent_status
        ]);

        $query->andFilterWhere(['like', 'vendor_name', $this->vendor_name])
            ->andFilterWhere(['like', 'vehicle', $this->vehicle])
            ->andFilterWhere(['like', 'container_no', $this->container_no])
            ->andFilterWhere(['like', 'month_periode', $this->month_periode])
            ->andFilterWhere(['like', 'item_type', $this->item_type]);

        return $dataProvider;
    }
}
