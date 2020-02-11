<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\DprGmcEffView;
use app\models\GeneralFunction;

class GmcMonthlyEffController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex($value='')
	{
		$data = $tmp_eff_arr = [];

		date_default_timezone_set('Asia/Jakarta');
        $model = new \yii\base\DynamicModel([
            'gmc', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date', 'gmc'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d') . '-11 month'));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

        $categories = GeneralFunction::instance()->getPeriodByRange($model->from_date, $model->to_date);

        if ($model->load($_GET)) {
            $eff_data_arr = DprGmcEffView::find()
            ->select([
                'period',
                'qty_time' => 'SUM(qty_time)',
                'mp_time' => 'SUM(mp_time)',
            ])
            ->where([
                'period' => $categories,
                'gmc' => $model->gmc
            ])
            ->groupBy('period')
            ->all();

            foreach ($categories as $key => $period_val) {
	            $tmp_eff = 0;
	            foreach ($eff_data_arr as $key => $eff_data) {
	                if ($period_val == $eff_data->period && $eff_data->mp_time > 0) {
	                    $tmp_eff = round(($eff_data->qty_time / $eff_data->mp_time) * 100, 1);
	                }
	            }
	            $tmp_eff_arr[] = $tmp_eff;
	        }
        }

        $data[] = [
            'name' => 'Efficiency',
            'data' => $tmp_eff_arr
        ];

		return $this->render('index', [
        	'model' => $model,
            'categories' => $categories,
            'data' => $data,
        ]);
	}
}