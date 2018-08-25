<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipPlanActualReport;

/**
* CisClientIpAddressSearch represents the model behind the search form about `app\models\CisClientIpAddress`.
*/
class WipPlanActualReportSearch extends WipPlanActualReport
{
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
		    [['period', 'slip_id', 'child_analyst', 'child_analyst_desc', 'model_group', 'parent', 'parent_desc', 'child', 'child_desc', 'stage', 'problem', 'slip_id_reference', 'fullfilment_stat', 'upload_id', 'period_line', 'session_id'], 'string'],
		    [['week'], 'integer'],
		    [['start_date', 'due_date', 'post_date', 'start_job', 'end_job', 'source_date'], 'safe'],
		    [['summary_qty'], 'number']
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
		$query = WipPlanActualReport::find();

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
            'week' => $this->week,
            'summary_qty' => $this->summary_qty,
            'session_id' => $this->session_id
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
        ->andFilterWhere(['like', 'slip_id', $this->slip_id])
        ->andFilterWhere(['like', 'upload_id', $this->upload_id])
        ->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
        ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc])
        ->andFilterWhere(['like', 'model_group', $this->model_group])
        ->andFilterWhere(['like', 'parent', $this->parent])
        ->andFilterWhere(['like', 'parent_desc', $this->parent_desc])
        ->andFilterWhere(['like', 'child', $this->child])
        ->andFilterWhere(['like', 'child_desc', $this->child_desc])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),start_date,120)', $this->start_date])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),due_date,120)', $this->due_date])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),post_date,120)', $this->post_date])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),source_date,120)', $this->source_date])
        ->andFilterWhere(['like', 'stage', $this->stage])
        ->andFilterWhere(['like', 'problem', $this->problem])
        ->andFilterWhere(['like', 'slip_id_reference', $this->slip_id_reference])
        ->andFilterWhere(['like', 'period_line', $this->period_line])
        ->andFilterWhere(['like', 'fullfilment_stat', $this->fullfilment_stat]);

		return $dataProvider;
	}
}