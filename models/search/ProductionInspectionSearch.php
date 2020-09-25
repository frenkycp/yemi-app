<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoInputAll;

/**
* ProductionInspectionSearch represents the model behind the search form about `app\models\SernoInput`.
*/
class ProductionInspectionSearch extends SernoInputAll
{
    public $status;
/**
* @inheritdoc
*/
public function rules()
{
return [
[['flo', 'adv'], 'integer'],
            [['pk', 'gmc', 'line', 'proddate', 'sernum', 'qa_ng_date', 'qa_ok_date', 'plan', 'etd_ship', 'status', 'loct'], 'safe'],
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
$query = SernoInputAll::find()
->select([
    'proddate' => 'proddate',
    'flo' => 'flo',
    'gmc' => 'gmc',
    'qa_ng' => 'qa_ng',
    'qa_ng_date' => 'qa_ng_date',
    'qa_ok' => 'qa_ok',
    'qa_ok_date' => 'qa_ok_date',
    'line' => 'line',
    'loct',
    'loct_time',
    'qa_result' => 'MAX(qa_result)',
    'total' => 'COUNT(gmc)',
])
->where([
    '<>', 'flo', 0
])
//->andWhere(['<>', 'status', 'LOT OUT'])
//->joinWith('sernoOutput')
//->joinWith('sernoMaster')
//->where(['<>', 'stc', 'ADVANCE'])
//->andWhere(['<>', 'flo', 0])
->groupBy('flo');

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    
    'sort' => [
        'attributes' => [
            'proddate',
            //'gmc',
            /*'etd_ship' => [
                'asc'=>['tb_serno_output.ship'=>SORT_ASC],
                'desc'=>['tb_serno_output.ship'=>SORT_DESC],
            ],
            'destination' => [
                'asc'=>['tb_serno_output.dst'=>SORT_ASC],
                'desc'=>['tb_serno_output.dst'=>SORT_DESC],
            ],*/
        ],
        'defaultOrder' => [
            //'proddate' => SORT_DESC,
            //'gmc' => SORT_ASC,
            //'etd_ship' => SORT_ASC,
            //'destination' => SORT_ASC,
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
            'flo' => $this->flo,
            'adv' => $this->adv,
            'loct' => $this->loct,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'tb_serno_input_all.gmc', $this->gmc])
            ->andFilterWhere(['like', 'line', $this->line])
            ->andFilterWhere(['like', 'proddate', $this->proddate])
            ->andFilterWhere(['like', 'sernum', $this->sernum])
            //->andFilterWhere(['like', 'qa_ng', $this->qa_ng])
            ->andFilterWhere(['like', 'qa_ng_date', $this->qa_ng_date])
            //->andFilterWhere(['like', 'qa_ok', $this->qa_ok])
            ->andFilterWhere(['like', 'qa_ok_date', $this->qa_ok_date])
            ->andFilterWhere(['like', 'plan', $this->plan])
            ->andFilterWhere(['like', 'tb_serno_output.ship', $this->etd_ship]);

        if ($this->status == 'OK') {
            $query->andWhere([
                'qa_ng' => '',
                'qa_ok' => 'OK'
            ]);
        } else if ($this->status == 'LOT OUT') {
            //$query->andWhere(['<>', 'qa_ng', ''])->andWhere(['<>', 'qa_result', 2]);
            $query->andWhere(['<>', 'qa_ng', ''])->andWhere(['qa_result' => 999]);
        } else if ($this->status == 'REPAIR') {
            $query->andWhere(['<>', 'qa_ng', ''])->andWhere(['qa_result' => 2]);
        }  elseif ($this->status == 'OPEN') {
            $query->andWhere([
                'qa_ng' => '',
                'qa_ok' => ''
            ]);
        }

return $dataProvider;
}
}