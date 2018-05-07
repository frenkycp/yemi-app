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
[['pk', 'stc', 'dst', 'gmc', 'etd'], 'safe'],
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
$query = SernoOutputModel::find();

if(isset($params['index_type']))
{
    if($params['index_type'] == 1)
    {
        $query = SernoOutputModel::find()->where('output<qty')->andWhere(['etd' => $params['etd']]);
    }
    elseif($params['index_type'] == 2)
    {
        $query = SernoOutputModel::find()->where('output=qty')->andWhere(['etd' => $params['etd']]);
    }
    elseif($params['index_type'] == 3)
    {
        $query = SernoOutputModel::find()->where('ng>0')->andWhere(['etd' => $params['etd']]);
    }

    if(isset($params['stc']))
    {
        $query = $query->andWhere(['stc' => $params['stc']]);
    }
}

$query->joinWith('sernoMaster');

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'attributes' => [
            'dst',
            'gmc',
            'description' => [
                'asc'=>['tb_serno_master.model'=>SORT_ASC],
                'desc'=>['tb_serno_master.model'=>SORT_DESC],
            ],
        ],
        'defaultOrder' => [
            'dst' => SORT_ASC,
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
            'id' => $this->id,
            'num' => $this->num,
            'qty' => $this->qty,
            'output' => $this->output,
            'adv' => $this->adv,
            'etd' => $this->etd,
            'cntr' => $this->cntr,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'stc', $this->stc])
            ->andFilterWhere(['like', 'dst', $this->dst])
            ->andFilterWhere(['like', 'gmc', $this->gmc]);

return $dataProvider;
}
}