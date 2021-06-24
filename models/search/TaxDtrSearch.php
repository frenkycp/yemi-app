<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaxDtr;

/**
* TaxDtrSearch represents the model behind the search form about `app\models\TaxDtr`.
*/
class TaxDtrSearch extends TaxDtr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['dtrid', 'no_seri', 'no', 'nama'], 'safe'],
            [['hargaSatuan', 'jumlahBarang', 'hargaTotal', 'diskon', 'dpp', 'ppn', 'tarifPpnbm', 'ppnbm', 'period'], 'number'],
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
$query = TaxDtr::find()->joinWith('taxHdr');

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        //'cust_desc' => SORT_ASC,
        'no_seri' => SORT_DESC,
        'no' => SORT_ASC,
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
            'hargaSatuan' => $this->hargaSatuan,
            'jumlahBarang' => $this->jumlahBarang,
            'hargaTotal' => $this->hargaTotal,
            'diskon' => $this->diskon,
            'dpp' => $this->dpp,
            'ppn' => $this->ppn,
            'tarifPpnbm' => $this->tarifPpnbm,
            'ppnbm' => $this->ppnbm,
            'period' => $this->period,
        ]);

        $query->andFilterWhere(['like', 'dtrid', $this->dtrid])
            ->andFilterWhere(['like', 'no_seri', $this->no_seri])
            ->andFilterWhere(['like', 'no', $this->no])
            ->andFilterWhere(['like', 'nama', $this->nama]);

return $dataProvider;
}
}