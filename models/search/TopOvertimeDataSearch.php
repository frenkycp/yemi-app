<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SplVIew;

/**
* TopOvertimeDataSearch represents the model behind the search form about `app\models\SplVIew`.
*/
class TopOvertimeDataSearch extends SplVIew
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
    return [
                [['SPL_HDR_ID', 'SPL_BARCODE', 'USER_DOC_RCV', 'USER_DESC_DOC_RCV', 'JENIS_LEMBUR', 'CC_ID', 'CC_GROUP', 'CC_DESC', 'USER_ID', 'USER_DESC', 'URAIAN_UMUM', 'STAT', 'SPL_DTR_ID', 'ID_NIK_AND_DATE', 'NO', 'NIK', 'NAMA_KARYAWAN', 'DIRECT_INDIRECT', 'GRADE', 'KODE_LEMBUR', 'URAIAN_LEMBUR', 'STAT_DTR', 'PAY', 'SPL_GROUP', 'KETERANGAN', 'DEPT_SECTION'], 'string'],
                [['TGL_LEMBUR', 'USER_LAST_UPDATE', 'DOC_RCV_DATE', 'DOC_VALIDATION_DATE', 'START_LEMBUR_PLAN', 'END_LEMBUR_PLAN', 'START_LEMBUR_ACTUAL', 'END_LEMBUR_ACTUAL', 'SPL_HDR_ID', 'SPL_BARCODE', 'TGL_LEMBUR', 'KETERANGAN', 'PERIOD'], 'safe'],
                [['NILAI_LEMBUR_PLAN'], 'number']
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
        if (\Yii::$app->request->get('section_id') == 1) {
            $query = SplVIew::find()
            ->select([
                'CC_ID',
                'CC_GROUP',
                'CC_DESC',
                'PERIOD',
                'NIK',
                'NAMA_KARYAWAN',
                'GRADE',
                'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
            ])
            ->where('NIK IS NOT NULL')
            ->andWhere([
                'CC_ID' => ['110B', '110C', '110D', '130A', '131', '200A', '220A', '230', '240', '300', '310', '320', '330', '340A', '340M', '350', '360', '370', '371', '399']
            ])
            ->groupBy('CC_ID, CC_GROUP, CC_DESC, PERIOD, NIK, NAMA_KARYAWAN, GRADE')
            ->having('SUM(NILAI_LEMBUR_ACTUAL) > 0');
        } elseif (\Yii::$app->request->get('section_id') == 2) {
            $query = SplVIew::find()
            ->select([
                'CC_ID',
                'CC_GROUP',
                'CC_DESC',
                'PERIOD',
                'NIK',
                'NAMA_KARYAWAN',
                'GRADE',
                'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
            ])
            ->where('NIK IS NOT NULL')
            ->andWhere([
                'CC_ID' => ['110A', '110E', '120', '130', '200', '210', '220', '250', '251']
            ])
            ->groupBy('CC_ID, CC_GROUP, CC_DESC, PERIOD, NIK, NAMA_KARYAWAN, GRADE')
            ->having('SUM(NILAI_LEMBUR_ACTUAL) > 0');
        } else {
            $query = SplVIew::find()
            ->select([
                'CC_ID',
                'CC_GROUP',
                'CC_DESC',
                'PERIOD',
                'NIK',
                'NAMA_KARYAWAN',
                'GRADE',
                'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
            ])
            ->where('NIK IS NOT NULL')
            ->groupBy('CC_ID, CC_GROUP, CC_DESC, PERIOD, NIK, NAMA_KARYAWAN, GRADE')
            ->having('SUM(NILAI_LEMBUR_ACTUAL) > 0');
        }
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
            	'defaultOrder' => [
                    //'PERIOD' => SORT_DESC,
                    'NILAI_LEMBUR_ACTUAL' => SORT_DESC,
                    //'NIK' => 'ASC'
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
            'PERIOD' => $this->PERIOD,
            'NIK' => $this->NIK,
            'CC_GROUP' => $this->CC_GROUP,
            'CC_DESC' => $this->CC_DESC,
            'GRADE' => $this->GRADE,
        ]);

        $query->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN]);

        return $dataProvider;
    }
}