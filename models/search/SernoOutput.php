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
[['pk', 'stc', 'gmc', 'etd', 'category', 'description', 'line', 'vms'], 'safe'],
            [['id', 'num', 'qty', 'output', 'adv', 'cntr'], 'integer'],
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
->select('tb_serno_output.id, dst, tb_serno_output.gmc, SUM( qty ) AS qty, SUM( output ) AS output, stc, vms, etd, ship, cntr, MAX(remark) AS remark')
->where(['<>', 'stc', 'ADVANCE'])
//->andWhere(['<>', 'stc', 'NOSO'])
->groupBy('uniq');

if(isset($params['index_type']))
{
    if($params['index_type'] == 1)
    {
        $query = $query->andWhere('output<qty')->andWhere(['etd' => $params['etd']]);
    }
    elseif($params['index_type'] == 2)
    {
        $query = $query->andWhere('output=qty OR output > 0')->andWhere(['etd' => $params['etd']]);
    }
    elseif($params['index_type'] == 3)
    {
        $query = $query->andWhere('ng>0')->andWhere(['etd' => $params['etd']]);
    }

    if(isset($params['dst']))
    {
        $query = $query->andWhere(['dst' => $params['dst']]);
    }
    if(isset($params['back_order']))
    {
        if ($params['back_order'] == 2) {
            $query = $query->andWhere(['back_order' => 2]);
        } else {
            $query = $query->andWhere(['<>', 'back_order', 2]);
        }
        
    }
}

$query->joinWith('sernoMaster');
$query->joinWith('shipCustomer');

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'attributes' => [
            'dst',
            'etd',
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
            'cust_desc' => SORT_ASC,
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
            'qty' => $this->qty,
            'output' => $this->output,
            'adv' => $this->adv,
            'cntr' => $this->cntr,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'stc', $this->stc])
            ->andFilterWhere(['like', 'etd', $this->etd])
            ->andFilterWhere(['like', 'tb_serno_master.model', $this->description])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'dst', $this->dst])
            ->andFilterWhere(['like', 'tb_serno_output.gmc', $this->gmc]);

return $dataProvider;
}
}