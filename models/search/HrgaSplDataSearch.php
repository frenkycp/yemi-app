<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SplView;

/**
* HrgaSplDataSearch represents the model behind the search form about `app\models\SplView`.
*/
class HrgaSplDataSearch extends SplView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SPL_HDR_ID', 'SPL_BARCODE', 'TGL_LEMBUR', 'JENIS_LEMBUR', 'CC_ID', 'CC_GROUP', 'CC_DESC', 'USER_ID', 'USER_DESC', 'USER_LAST_UPDATE', 'DOC_RCV_DATE', 'USER_DOC_RCV', 'USER_DESC_DOC_RCV', 'DOC_VALIDATION_DATE', 'URAIAN_UMUM', 'STAT', 'NIK', 'NAMA_KARYAWAN', 'DEPT_SECTION'], 'safe'],
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
$query = SplView::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        'TGL_LEMBUR' => SORT_ASC,
        'CC_GROUP' => SORT_ASC,
        'NIK' => SORT_ASC
    ]
],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

/*$query->andFilterWhere([
            'TGL_LEMBUR' => $this->TGL_LEMBUR,
        ]);*/

        $query->andFilterWhere(['like', 'JENIS_LEMBUR', $this->JENIS_LEMBUR])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),TGL_LEMBUR,120)', $this->TGL_LEMBUR])
            ->andFilterWhere(['like', 'CC_GROUP', $this->CC_GROUP])
            ->andFilterWhere(['like', 'SPL_HDR_ID', $this->SPL_HDR_ID])
            ->andFilterWhere(['like', 'DEPT_SECTION', $this->DEPT_SECTION])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'CC_DESC', $this->CC_DESC]);

return $dataProvider;
}
}