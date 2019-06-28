<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\CrusherTbl;

class CrusherChartController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$data = [];
		$period = date('Ym');

		$model = new \yii\base\DynamicModel([
	        'start_date', 'end_date'
	    ]);
	    $model->addRule(['start_date', 'end_date'], 'required');

	    if ($model->load($_GET)) {
	    	$tmp_crusher = CrusherTbl::find()
			->select([
				'date', 'model',
				'consume' => 'SUM(consume)'
			])
			->where(['>=', 'date', $model->start_date])
			->andWhere(['<=', 'date', $model->end_date])
			->groupBy('date, model')
			->all();

			$tmp_data = [];
			foreach ($tmp_crusher as $key => $value) {
				$proddate = (strtotime($value->date . " +7 hours") * 1000);
				$tmp_data[$value->model][] = [
					'x' => $proddate,
					'y' => round($value->consume, 1)
				];
			}

			foreach ($tmp_data as $key => $value) {
				$data[] = [
					'name' => $key,
					'data' => $value,
				];
			}
	    }

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
		]);
	}
}