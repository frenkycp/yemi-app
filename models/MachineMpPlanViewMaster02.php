<?php

namespace app\models;

use Yii;
use \app\models\base\MachineMpPlanViewMaster02 as BaseMachineMpPlanViewMaster02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_MP_PLAN_VIEW_MASTER_02".
 */
class MachineMpPlanViewMaster02 extends BaseMachineMpPlanViewMaster02
{
    public $total_open, $total_close, $total_plan, $min_year, $machine_img, $standart_time, $manpower, $pic, $plan_date, $date_status;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function getPlanDate()
    {
        $tmp_data = MachineMpPlanViewMaster02::find()
        ->where([
            'mesin_id' => $this->mesin_id,
            'mesin_periode' => $this->mesin_periode
        ])
        ->andWhere(['<', 'master_plan_maintenance', $this->master_plan_maintenance])
        ->orderBy('master_plan_maintenance DESC')
        ->one();

        $plan_date = date('d-M-Y', strtotime($this->master_plan_maintenance));
        if ($tmp_data->master_plan_maintenance != null) {
            $mesin_periode_split = explode('-', $this->mesin_periode);
            $plan_date = date('d-M-Y', strtotime($tmp_data->master_plan_maintenance . ' + ' . $mesin_periode_split[0] . 'month'));
        }

        return $plan_date;
    }
}
