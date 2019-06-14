<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Url;

use app\models\ShiftPatrolTbl;

class ShiftPatrolDashboardController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
		$data = [];
		$outstanding_categories = [];

		$tmp_outstanding = ShiftPatrolTbl::find()
		->select([
			'section_id', 'section_group', 'section_desc',
			'total_open' => 'SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END)',
			'total_pending' => 'SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END)',
			'total_rejected' => 'SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END)',
			'total_closed' => 'SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END)',
			'total_ok_due_date' => 'SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END)',
			'total_all' => 'SUM(CASE WHEN status <> 1 THEN 1 ELSE 0 END)',
		])
		->where([
			'flag' => 1
		])
		->andWhere('section_id IS NOT NULL')
		->andWhere(['<>', 'status', 1])
		->groupBy('section_id, section_group, section_desc')
		->orderBy('total_all DESC, section_desc')
		->asArray()
		->all();
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
			$outstanding_categories[] = $value['section_desc'];
			$total_open = $value['total_open'] == 0 ? null : (int)$value['total_open'];
			$total_pending = $value['total_pending'] == 0 ? null : (int)$value['total_pending'];
			$total_rejected = $value['total_rejected'] == 0 ? null : (int)$value['total_rejected'];
			$total_ok = $value['total_ok_due_date'] == 0 ? null : (int)$value['total_ok_due_date'];
			$outstanding_data[0]['data'][] = [
				'y' => $total_open,
				'url' => Url::to(['shift-patrol-tbl/index', 'status' => 0, 'section_id' => $value['section_id']]),
			];
			$outstanding_data[1]['data'][] = [
				'y' => $total_pending,
				'url' => Url::to(['shift-patrol-tbl/index', 'status' => 2, 'section_id' => $value['section_id']]),
			];
			$outstanding_data[2]['data'][] = [
				'y' => $total_ok,
				'url' => Url::to(['shift-patrol-tbl/index', 'status' => 4, 'section_id' => $value['section_id']]),
			];
			$outstanding_data[3]['data'][] = [
				'y' => $total_rejected,
				'url' => Url::to(['shift-patrol-tbl/index', 'status' => 3, 'section_id' => $value['section_id']]),
			];
		}

		$data['outstanding'] = [
			'categories' => $outstanding_categories,
			'data' => $outstanding_data
		];

		$ok_due_date = ShiftPatrolTbl::find()
		->select([
			'due_date',
			'total_qty' => 'COUNT(section_id)'
		])
		->where([
			'flag' => 1,
			'status' => 4
		])
		->groupBy('due_date')
		->orderBy('due_date')
		->all();

		$tmp_data_ok = [];
		foreach ($ok_due_date as $key => $value) {
			$due_date = (strtotime($value->due_date . " +7 hours") * 1000);
			$tmp_data_ok[] = [
				'x' => $due_date,
				'y' => (int)$value->total_qty,
				'url' => Url::to(['shift-patrol-tbl/index', 'status' => 4, 'due_date' => date('Y-m-d', strtotime($value->due_date))]),
			];
		}

		$data['ok'] = [
			'data' => [
				[
					'name' => 'OK With Due Date',
					'data' => $tmp_data_ok,
					'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
					'showInLegend' => false
				]
			],
		];

		return $this->render('index', [
			'data' => $data,
		]);
	}
}