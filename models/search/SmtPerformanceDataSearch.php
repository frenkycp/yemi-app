<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipEffNew03;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class SmtPerformanceDataSearch extends WipEffNew03
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['child_analyst', 'child_analyst_desc', 'period', 'LINE', 'SMT_SHIFT', 'child_all', 'child_desc_all'], 'string'],
            [['post_date'], 'safe'],
            [['qty_all', 'std_all', 'lt_std', 'lt_gross', 'planed_loss_minute', 'out_section_minute', 'dandori_minute', 'break_down_minute', 'operating_loss_minute', 'operating_ratio', 'working_ratio'], 'number']
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
        $query = WipEffNew03::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    //'cust_desc' => SORT_ASC,
                    'post_date' => SORT_DESC,
                    'LINE' => SORT_ASC,
                    'SMT_SHIFT' => SORT_ASC,
                    'child_all' => SORT_ASC,
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
            'post_date' => $this->post_date,
            'LINE' => $this->LINE,
            'SMT_SHIFT' => $this->SMT_SHIFT,
            'child_all' => $this->child_all,
            'child_analyst' => $this->child_analyst,
        ]);
        /*$query->andFilterWhere([
                    'YEAR' => $this->YEAR,
                    'WEEK' => $this->WEEK,
                    'DATE' => $this->DATE,
                    'TOTAL_KARYAWAN' => $this->TOTAL_KARYAWAN,
                    'KEHADIRAN' => $this->KEHADIRAN,
                    'BONUS' => $this->BONUS,
                    'DISIPLIN' => $this->DISIPLIN,
                ]);

                $query->andFilterWhere(['like', 'NIK_DATE_ID', $this->NIK_DATE_ID])
                    ->andFilterWhere(['like', 'NO', $this->NO])
                    ->andFilterWhere(['like', 'NIK', $this->NIK])
                    ->andFilterWhere(['like', 'CC_ID', $this->CC_ID])
                    ->andFilterWhere(['like', 'SECTION', $this->SECTION])
                    ->andFilterWhere(['like', 'DIRECT_INDIRECT', $this->DIRECT_INDIRECT])
                    ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
                    ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
                    ->andFilterWhere(['like', 'NOTE', $this->NOTE])
                    ->andFilterWhere(['like', 'DAY_STAT', $this->DAY_STAT])
                    ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY]);*/

        return $dataProvider;
    }
}