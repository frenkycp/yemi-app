<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MesinCheckDtr;

/**
* MesinCheckDtrSearch represents the model behind the search form about `app\models\MesinCheckDtr`.
*/
class MesinCheckDtrSearch extends MesinCheckDtr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['master_id', 'mesin_id', 'machine_desc', 'location', 'area', 'mesin_periode', 'r01', 'r02', 'r03', 'r04', 'r05', 'r06', 'r07', 'r08', 'r09', 'r10', 'r11', 'r12', 'r13', 'r14', 'r15', 'r16', 'r17', 'r18', 'r19', 'r20', 'r21', 'r22', 'r23', 'r24', 'r25', 'r26', 'r27', 'r28', 'r29', 'r30', 'r31', 'r32', 'r33', 'r34', 'r35', 'r36', 'r37', 'r38', 'r39', 'r40', 'r41', 'r42', 'r43', 'r44', 'r45', 'r46', 'r47', 'r48', 'r49', 'r50', 'b01', 'b02', 'b03', 'b04', 'b05', 'b06', 'b07', 'b08', 'b09', 'b10', 'b11', 'b12', 'b13', 'b14', 'b15', 'b16', 'b17', 'b18', 'b19', 'b20', 'b21', 'b22', 'b23', 'b24', 'b25', 'b26', 'b27', 'b28', 'b29', 'b30', 'b31', 'b32', 'b33', 'b34', 'b35', 'b36', 'b37', 'b38', 'b39', 'b40', 'b41', 'b42', 'b43', 'b44', 'b45', 'b46', 'b47', 'b48', 'b49', 'b50', 'd01', 'd02', 'd03', 'd04', 'd05', 'd06', 'd07', 'd08', 'd09', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'd16', 'd17', 'd18', 'd19', 'd20', 'd21', 'd22', 'd23', 'd24', 'd25', 'd26', 'd27', 'd28', 'd29', 'd30', 'd31', 'd32', 'd33', 'd34', 'd35', 'd36', 'd37', 'd38', 'd39', 'd40', 'd41', 'd42', 'd43', 'd44', 'd45', 'd46', 'd47', 'd48', 'd49', 'd50', 's01', 's02', 's03', 's04', 's05', 's06', 's07', 's08', 's09', 's10', 's11', 's12', 's13', 's14', 's15', 's16', 's17', 's18', 's19', 's20', 's21', 's22', 's23', 's24', 's25', 's26', 's27', 's28', 's29', 's30', 's31', 's32', 's33', 's34', 's35', 's36', 's37', 's38', 's39', 's40', 's41', 's42', 's43', 's44', 's45', 's46', 's47', 's48', 's49', 's50', 'c01', 'c02', 'c03', 'c04', 'c05', 'c06', 'c07', 'c08', 'c09', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'c17', 'c18', 'c19', 'c20', 'c21', 'c22', 'c23', 'c24', 'c25', 'c26', 'c27', 'c28', 'c29', 'c30', 'c31', 'c32', 'c33', 'c34', 'c35', 'c36', 'c37', 'c38', 'c39', 'c40', 'c41', 'c42', 'c43', 'c44', 'c45', 'c46', 'c47', 'c48', 'c49', 'c50', 'user_id', 'user_desc', 'master_plan_maintenance', 'mesin_last_update', 'mesin_next_schedule'], 'safe'],
            [['sisa_waktu', 'count_list', 'count_update'], 'integer'],
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
$query = MesinCheckDtr::find()->where(['not', ['master_plan_maintenance' => null]]);
if (isset($_GET['status'])) {
      if ($_GET['status'] == 0) {
            $query = MesinCheckDtr::find()->where(['not', ['master_plan_maintenance' => null]])->andWhere(['mesin_last_update' => null]);
      }else {
            $query = MesinCheckDtr::find()->where(['not', ['master_plan_maintenance' => null]])->andWhere(['not', ['mesin_last_update' => null]]);
      }
}

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
            'mesin_next_schedule' => $this->mesin_next_schedule,
            'sisa_waktu' => $this->sisa_waktu,
            'count_list' => $this->count_list,
            'count_update' => $this->count_update,
        ]);

        $query->andFilterWhere(['like', 'master_id', $this->master_id])
            ->andFilterWhere(['like', 'mesin_id', $this->mesin_id])
            ->andFilterWhere(['like', 'machine_desc', $this->machine_desc])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'mesin_periode', $this->mesin_periode])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),master_plan_maintenance,120)', $this->master_plan_maintenance])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),mesin_last_update,120)', $this->mesin_last_update])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_desc', $this->user_desc]);

return $dataProvider;
}
}