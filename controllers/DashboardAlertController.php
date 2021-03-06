<?php

namespace app\controllers;

use yii\web\Controller;

use app\models\MachineIotCurrent;
use app\models\SernoLosstime;
use app\models\MachineIotCurrentEff;

class DashboardAlertController extends Controller
{
	public function actionIndex()
	{
		$this->layout = 'clean';
		return $this->render('index');
	}

	public function actionMachineStatus()
	{
		//$tmp_data = MachineIotCurrent::find()->where(['status_warna' => ['BIRU', 'KUNING']])->orderBy('mesin_description')->all();
		$tmp_data = MachineIotCurrent::find()->where(['status_warna' => 'MERAH'])->orderBy('mesin_description')->all();
		$content_str = '';
		$status = 1;
		if (!$tmp_data) {
			//$content_str = '<span class="text-green" style="font-size: 20px;">All Machines are Running Normally ...</span>';
		} else {
			$status = 0;
			foreach ($tmp_data as $key => $value) {
				$content_str .= '
					<div class="col-md-3">
						<div class="small-box bg-red">
							<div class="inner">
		              			<h3>' . $value->mesin_id . '</h3>
		              			<p>' . $value->mesin_description . '</p>
		            		</div>
		            		<div class="icon">
		              			<i class="fa fa-cogs"></i>
		            		</div>
		            		<a href="#" class="small-box-footer">
              					
            				</a>
						</div>
					</div>';
				//$content_str .= '<button type="button" class="btn btn-danger btn-block"">' . $value->mesin_id . ' - ' . $value->mesin_description . '</button>';
			}
		}
		$return_data = [
			'status' => $status,
			'content_str' => $content_str
		];
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		return $return_data;
	}

	public function actionLineStatus()
	{
		//$proddate = '2019-06-11';
		$proddate = date('Y-m-d');
		$line_stop = SernoLosstime::find()
		->where([
			//'proddate' => date('Y-m-d'),
			'proddate' => $proddate,
			'stopline' => 'STOPLINE'
		])
		->andWhere(['<>', 'line', ''])
		->andWhere(['<>', 'category', 'CM'])
		->andWhere(['<>', 'category', 'UNKNOWN'])
		->andWhere(['<>', 'category', 'HP'])
		->all();
		$content_str = '';
		$status = 1;

		if (!$line_stop) {
			//$content_str = '<span class="text-green" style="font-size: 20px;">All Lines are Running Normally ...</span>';
		} else {
			$status = 0;
			foreach ($line_stop as $key => $value) {
				$content_str .= '
					<div class="col-md-3">
						<div class="small-box bg-red">
							<div class="inner">
		              			<h3>LINE ' . $value->line . ' [ ' . $value->category . ' ]</h3>
		              			<p>' . $value->reason . '</p>
		            		</div>
		            		<div class="icon">
		              			<i class="fa fa-map-marker"></i>
		            		</div>
		            		<a href="#" class="small-box-footer">
              					
            				</a>
						</div>
					</div>';
			}
		}

		$return_data = [
			'status' => $status,
			'content_str' => $content_str
		];
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		return $return_data;
	}

}