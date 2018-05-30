<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoOutput as SernoOutputModel;

/**
* SernoOutput represents the model behind the search form about `app\models\SernoOutput`.
*/
class YemiInternalSearch extends SernoOutputModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['pk', 'stc', 'dst', 'gmc', 'etd', 'category', 'description', 'line', 'vms'], 'safe'],
            [['id', 'num', 'adv', 'cntr', 'is_minus', 'qty', 'output'], 'integer'],
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
$query = SernoOutputModel::find();

//$query = SernoOutputModel::find()->where('output<qty');

if(isset($params['index_type']))
{
    if($params['index_type'] == 1)
    {
        $query = SernoOutputModel::find()->where('output<qty')->andWhere(['vms' => $params['vms']]);
    }
    elseif($params['index_type'] == 2)
    {
        $query = SernoOutputModel::find()->where('output=qty')->andWhere(['vms' => $params['vms']]);
    }
    elseif($params['index_type'] == 3)
    {
        $query = SernoOutputModel::find()->where('ng>0')->andWhere(['vms' => $params['vms']]);
    }
}

$query->joinWith('sernoMaster');
$query->joinWith('shipCustomer');

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'attributes' => [
            'line',
            'vms',
            'gmc',
            'etd',
            'cust_desc' => [
                'asc'=>['tb_ship_customer.customer_desc'=>SORT_ASC],
                'desc'=>['tb_ship_customer.customer_desc'=>SORT_DESC],
            ],
            'description' => [
                'asc'=>['tb_serno_master.model'=>SORT_ASC],
                'desc'=>['tb_serno_master.model'=>SORT_DESC],
            ],
            'num'
        ],
        'defaultOrder' => [
            'vms' => SORT_ASC,
            'line' => SORT_ASC,
            'num' => SORT_ASC
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
            'tb_serno_output.id' => $this->id,
            //'num' => $this->num,
            //'qty' => $this->qty,
            //'output' => $this->output,
            'adv' => $this->adv,
            'cntr' => $this->cntr,
            'vms' => $this->vms,
            'tb_serno_master.line' => $this->line,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'stc', $this->stc])
            ->andFilterWhere(['like', 'etd', $this->etd])
            ->andFilterWhere(['like', 'tb_serno_master.model', $this->description])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'dst', $this->dst])
            ->andFilterWhere(['like', 'tb_serno_output.gmc', $this->gmc]);

        if ($this->is_minus == 1) {
            $query->andFilterWhere(['<>', '(qty - output)', 0]);
        }

return $dataProvider;
}
}