<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\HakAksesPlus;
use app\models\DprLineEfficiencyView02;

class FaMonthlyEfficiencyController extends Controller
{
	public function actionIndex($value='')
	{
		date_default_timezone_set('Asia/Jakarta');
		$data = $tmp_data = [];

		$model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        $model->load($_GET);

		$line_eff_arr = DprLineEfficiencyView02::find()
		->select([
			'line', 'proddate', 'efficiency'
		])
		->where(['AND', ['>=', 'proddate', $model->from_date], ['<=', 'proddate', $model->to_date]])
		->orderBy('line, proddate')
		->asArray()
		->all();

		foreach ($line_eff_arr as $key => $value) {
			$proddate = (strtotime($value['proddate'] . " +7 hours") * 1000);
			$tmp_data[$value['line']][] = [
				'x' => $proddate,
	    		'y' => $value['efficiency'] == 0 ? null : round($value['efficiency'], 2),
			];
		}
		$color_arr = \Yii::$app->params['fav_color_arr'];

		$index_color = 0;
		foreach ($tmp_data as $key => $value) {
			$data[] = [
				'name' => $key,
				'data' => $value,
				//'lineWidth' => 0.8,
				'color' => $color_arr[$index_color]
			];
			$index_color++;
		}

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
		]);
	}
}