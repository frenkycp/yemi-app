<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ContainerView;

class ContainerViewSearch  extends ContainerView
{
	public function rules()
    {
        return [
            [['id', 'week_no', 'total_cntr'], 'integer'],
            [['etd'], 'safe'],
            [['qty', 'output', 'balance'], 'number'],
            [['stc'], 'string', 'max' => 6],
            [['customer_desc'], 'string', 'max' => 100]
        ];
    }

    public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function search($params)
	{
	$query = ContainerView::find();

	$dataProvider = new ActiveDataProvider([
	    'query' => $query,
	]);

	$this->load($params);

	if (!$this->validate()) {
	// uncomment the following line if you do not want to any records when validation fails
	// $query->where('0=1');
	return $dataProvider;
	}

	$query->andFilterWhere([
	            'id' => $this->id,
	            'week_no' => $this->week_no,
	            'total_cntr' => $this->total_cntr,
	            'etd' => $this->etd,
	        ]);

	        $query->andFilterWhere(['like', 'stc', $this->stc])
	            ->andFilterWhere(['like', 'customer_desc', $this->customer_desc]);

	return $dataProvider;
	}
}