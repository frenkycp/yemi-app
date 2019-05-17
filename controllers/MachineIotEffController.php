<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;

use app\models\MachineIotAvailabilityEff02;

class MachineIotEffController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$data = [
			'availability' => [
				'categories' => [],
				'data' => [
					[
						'name' => 'Availability',
						'data' => [],
						'showInLegend' => false,
					]
				]
			],
			'efficiency' => [
				'categories' => [],
				'data' => [
					[
						'name' => 'Efficiency',
						'data' => [],
						'showInLegend' => false,
					]
				]
			],
		];
		$categories = [];
		$posting_date = date('Y-m-d');
		if (\Yii::$app->request->get('posting_date') !== null) {
			$posting_date = \Yii::$app->request->get('posting_date');
		}

		$data_arr1 = MachineIotAvailabilityEff02::find()
		->where([
			'posting_date' => $posting_date
		])
		->orderBy('availability DESC, mesin_description ASC')
		->all();

		$data_arr2 = MachineIotAvailabilityEff02::find()
		->where([
			'posting_date' => $posting_date
		])
		->orderBy('efficiency DESC, mesin_description ASC')
		->all();

		foreach ($data_arr1 as $key => $value) {
			$data['availability']['categories'][] = $value->mesin_description;
			$data['availability']['data'][0]['data'][] = [
				'y' => $value->availability,
				'url' => Url::to(['mnt-kwh-report/index', 'posting_date' => $posting_date, 'machine_id' => $value->mesin_id]),
			];
		}

		foreach ($data_arr2 as $key => $value) {
			$data['efficiency']['categories'][] = $value->mesin_description;
			$data['efficiency']['data'][0]['data'][] = [
				'y' => $value->efficiency,
				'url' => Url::to(['mnt-kwh-report/index', 'posting_date' => $posting_date, 'machine_id' => $value->mesin_id]),
			];
		}

		return $this->render('index', [
			'data' => $data,
			'posting_date' => $posting_date
		]);
	}
}