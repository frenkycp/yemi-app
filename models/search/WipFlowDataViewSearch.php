<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipFlowView02;

/**
* CisClientIpAddressSearch represents the model behind the search form about `app\models\CisClientIpAddress`.
*/
class WipFlowDataViewSearch extends WipFlowView02
{
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
		    [['period', 'child_analyst', 'child_analyst_desc', 'model_group', 'parent', 'parent_desc', 'period_line'], 'string'],
            [['due_date', 'start_date', 'end_date'], 'safe'],
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
		$query = WipFlowView02::find();

		if (isset($params['start_date'])) {
			$query = WipFlowView02::find()
			->where(['>=', 'due_date', $params['start_date']])
			->andWhere(['<=', 'due_date', $params['end_date']]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
		        'defaultOrder' => [
		            //'cust_desc' => SORT_ASC,
		            //'bom_level' => SORT_ASC,
		        ]
		    ],
		]);

		$this->load($params);

		if (!$this->validate()) {
		// uncomment the following line if you do not want to any records when validation fails
		// $query->where('0=1');
		return $dataProvider;
		}

		$query->andFilterWhere([
            'child_analyst_desc' => $this->child_analyst_desc,
            'parent' => $this->parent,
            'period' => $this->period
        ]);
/**/
        $query->andFilterWhere(['like', 'model_group', $this->model_group])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),due_date,120)', $this->due_date])
        ->andFilterWhere(['like', 'parent_desc', $this->parent_desc]);

		return $dataProvider;
	}
}