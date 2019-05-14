<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Url;
use app\models\IpqaPatrolOutstandingView;

class IpqaDashboardController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$data = [];
		$outstanding_categories = [];

		$tmp_outstanding = IpqaPatrolOutstandingView::find()->orderBy('CC_DESC')->asArray()->all();
		$outstanding_data = [
			[
				'name' => 'OPEN',
				'data' => [],
				'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
			],
			[
				'name' => 'PENDING',
				'data' => [],
				'color' => new JsExpression('Highcharts.getOptions().colors[6]'),
			],
			[
				'name' => 'OK WITH DUE DATE',
				'data' => [],
				'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
			],
			[
				'name' => 'REJECTED',
				'data' => [],
				'color' => new JsExpression('Highcharts.getOptions().colors[8]'),
			],
		];
		foreach ($tmp_outstanding as $key => $value) {
			$outstanding_categories[] = $value['CC_DESC'];
			$total_open = $value['total_open'] == 0 ? null : (int)$value['total_open'];
			$total_pending = $value['total_pending'] == 0 ? null : (int)$value['total_pending'];
			$total_rejected = $value['total_rejected'] == 0 ? null : (int)$value['total_rejected'];
			$total_ok = $value['total_ok_due_date'] == 0 ? null : (int)$value['total_ok_due_date'];
			$outstanding_data[0]['data'][] = [
				'y' => $total_open,
				'url' => Url::to(['ipqa-patrol-tbl/index', 'status' => 0, 'CC_ID' => $value['CC_ID']]),
			];
			$outstanding_data[1]['data'][] = [
				'y' => $total_pending,
				'url' => Url::to(['ipqa-patrol-tbl/index', 'status' => 2, 'CC_ID' => $value['CC_ID']]),
			];
			$outstanding_data[2]['data'][] = [
				'y' => $total_ok,
				'url' => Url::to(['ipqa-patrol-tbl/index', 'status' => 2, 'CC_ID' => $value['CC_ID']]),
			];
			$outstanding_data[3]['data'][] = [
				'y' => $total_rejected,
				'url' => Url::to(['ipqa-patrol-tbl/index', 'status' => 3, 'CC_ID' => $value['CC_ID']]),
			];
		}
		$data['outstanding'] = [
			'categories' => $outstanding_categories,
			'data' => $outstanding_data
		];

		return $this->render('index', [
			'data' => $data,
		]);
	}
}