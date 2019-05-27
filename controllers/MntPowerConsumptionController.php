<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;

use app\models\MachineIot;

class MntPowerConsumptionController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		//$machine_id = 'MNT00211';
		$posting_date = date('Y-m-d');
		$categories = [];

		$model = new \yii\base\DynamicModel([
	        'posting_date', 'machine_id'
	    ]);
	    $model->addRule(['posting_date','machine_id'], 'required');
	    /*$model->posting_date = $posting_date;

		if (\Yii::$app->request->get('posting_date') !== null) {
			$model->posting_date = \Yii::$app->request->get('posting_date');
		}

		if (\Yii::$app->request->get('machine_id') !== null) {
			$model->machine_id = \Yii::$app->request->get('machine_id');
		}*/

		if ($model->load($_GET)) {
			$data_report = MachineIot::find()
			->select([
				'posting_date', 'mesin_id', 'jam_no',
				'start_kwh' => 'MIN(kwh)',
				'end_kwh' => 'MAX(kwh)',
			])
			->where([
				'FORMAT(posting_date, \'yyyy-MM-dd\')' => $model->posting_date,
				'mesin_id' => $model->machine_id,
			])
			->groupBy('posting_date, mesin_id, jam_no')
			->orderBy('jam_no')
			->asArray()
			->all();

			$tmp_data_kwh = $tmp_data_max_kwh = [];
			for ($i=0; $i < 24; $i++) { 
				$kwh = 0;
				$max_kwh = 0;
				foreach ($data_report as $key => $value) {
					if ($i == $value['jam_no']) {
						$start_kwh = (int)$value['start_kwh'];
						$end_kwh = (int)$value['end_kwh'];
						$kwh = $end_kwh - $start_kwh;
						$max_kwh = $end_kwh;
						break;
					}
				}
				$categories[] = $i;
				$tmp_data_kwh[] = $kwh == 0 ? null : $kwh;
				$tmp_data_max_kwh[] = $max_kwh == 0 ? null : $max_kwh;
			}

			$data = [
				[
					'name' => 'KWH Measured',
					'data' => $tmp_data_max_kwh,
					'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
					'yAxis' => 1,
					//'showInLegend' => false,
					'dataLabels' => [
						'enabled' => true,
						//'format' => '{y} KWh'
					],
				],
				[
					'name' => 'KWH Consumption',
					'data' => $tmp_data_kwh,
					'color' => new JsExpression('Highcharts.getOptions().colors[8]'),
					//'showInLegend' => false,
					'dataLabels' => [
						'enabled' => true,
						//'format' => '{y} KWh'
					],
				]
			];
		}

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
			'posting_date' => $posting_date,
			'machine_id' => $machine_id,
			'categories' => $categories,
		]);
	}
}