<?php

namespace app\controllers;

use yii\web\Controller;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\PalletPointView;

class PalletOrderCompletionController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$driver_arr_data = User::find()
		->where([
			'role_id' => [19, 20]
		])
		->orderBy('name')
		->all();

		$tmp_data = [];
		foreach ($driver_arr_data as $key => $value) {
			$nik = $value->username;
			$data_arr = PalletPointView::find()->where([
				'nik' => $nik
			])->all();

			$total_point = 0;
			if (count($data_arr) > 0) {
				foreach ($data_arr as $key2 => $value2) {
					$order_date = (strtotime($value2->order_date . " +7 hours") * 1000);
					$tmp_data[$nik]['open'][] = [
						'x' => $order_date,
						'y' => $value2->total_open == 0 ? null : (int)$value2->total_open,
					];
					$tmp_data[$nik]['close'][] = [
						'x' => $order_date,
						'y' => $value2->total_close == 0 ? null : (int)$value2->total_close,
					];
					$tmp_data[$nik]['nama'] = $value->name;
					$total_point = $value2->total_close;
				}
			} else {
				$tmp_data[$nik]['open'] = null;
				$tmp_data[$nik]['close'] = null;
				$tmp_data[$nik]['nama'] = $value->name;
			}
			$tmp_data[$nik]['todays_point'] = $total_point;
		}

		$data = [];
		foreach ($tmp_data as $key => $value) {
			$data[$key]['data'] = [
				[
					'name' => 'OPEN',
					'data' => $value['open'],
					'color' => 'rgba(255, 0, 0, 0.6)'
				],
				[
					'name' => 'CLOSE',
					'data' => $value['close'],
					'color' => 'rgba(0, 255, 0, 0.6)'
				]
			];
			$data[$key]['nama'] = $value['nama'];
			$data[$key]['todays_point'] = $value['todays_point'];
		}

		return $this->render('index', [
			'data' => $data,
		]);
	}
}