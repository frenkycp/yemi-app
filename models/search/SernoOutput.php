<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoOutput as SernoOutputModel;

/**
* SernoOutput represents the model behind the search form about `app\models\SernoOutput`.
*/
class SernoOutput extends SernoOutputModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['pk', 'stc', 'gmc', 'etd', 'category', 'description', 'line', 'vms', 'dst', 'etd_old', 'so'], 'safe'],
            [['id', 'num', 'adv', 'cntr', 'back_order', 'week_no'], 'integer'],
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
//$query = SernoOutputModel::find();
$query = SernoOutputModel::find()
->select([
    'tb_serno_output.id',
    'so',
    'dst',
    'tb_serno_output.gmc',
    'qty' => 'SUM(qty)',
    'output' => 'SUM(output)',
    'stc',
    'vms',
    'etd',
    'etd_old',
    'ship',
    'cntr',
    'back_order',
    'remark' => 'MAX(remark)',
    'week_no' => 'week(ship, 4)'
])
->where(['<>', 'stc', 'ADVANCE'])
->groupBy('uniq, so');

if(isset($params['index_type']))
{
    if($params['index_type'] == 1)
    {
        $query = $query->andWhere('output<qty')->andWhere(['etd' => $params['etd']]);
    }
    elseif($params['index_type'] == 2)
    {
        $query = $query->andWhere('output=qty')->andWhere(['etd' => $params['etd']]);
    }
    elseif($params['index_type'] == 3)
    {
        $query = $query->andWhere('ng>0')->andWhere(['etd' => $params['etd']]);
    }

    if(isset($params['dst']))
    {
        $query = $query->andWhere(['dst' => $params['dst']]);
    }
    /*if(isset($params['back_order']))
    {
        if ($params['back_order'] == 2) {
            $query = $query->andWhere(['back_order' => 2]);
        } else {
            $query = $query->andWhere(['<>', 'back_order', 2]);
        }
        
    }*/
}

$query->joinWith('sernoMaster');
$query->joinWith('shipCustomer');

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'attributes' => [
            'dst',
            'etd',
            'etd_old',
            'gmc',
            'cntr',
            'cust_desc' => [
                'asc'=>['tb_ship_customer.customer_desc'=>SORT_ASC],
                'desc'=>['tb_ship_customer.customer_desc'=>SORT_DESC],
            ],
            'description' => [
                'asc'=>['tb_serno_master.model'=>SORT_ASC],
                'desc'=>['tb_serno_master.model'=>SORT_DESC],
            ],
        ],
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'gmc' => SORT_ASC,
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
            'num' => $this->num,
            'so' => $this->so,
            'qty' => $this->qty,
            'output' => $this->output,
            'back_order' => $this->back_order,
            'adv' => $this->adv,
            'cntr' => $this->cntr,
            'week(ship, 4)' => $this->week_no,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'stc', $this->stc])
            ->andFilterWhere(['like', 'etd', $this->etd])
            ->andFilterWhere(['like', 'etd_old', $this->etd_old])
            ->andFilterWhere(['like', 'tb_serno_master.model', $this->description])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'dst', $this->dst])
            ->andFilterWhere(['like', 'tb_serno_output.gmc', $this->gmc]);

return $dataProvider;
}
}