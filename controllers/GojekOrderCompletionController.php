<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\search\ContainerViewSearch;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\GojekOrderTbl;
use app\models\GojekTbl;

class GojekOrderCompletionController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		$data = [];
		$categories = [];
		$order_data_arr = GojekTbl::find()
		->joinWith('gojekOrderTbl')
		->select([
			'GOJEK_TBL.GOJEK_ID',
			'GOJEK_TBL.GOJEK_DESC',
			'stat_open' => 'SUM(CASE WHEN STAT = \'O\' THEN 1 ELSE 0 END)',
			'stat_close' => 'SUM(CASE WHEN STAT = \'C\' THEN 1 ELSE 0 END)',
			'stat_total' => 'COUNT(STAT)'
		])
		->groupBy('GOJEK_TBL.GOJEK_ID, GOJEK_TBL.GOJEK_DESC')
		->orderBy('GOJEK_TBL.GOJEK_DESC')
		->all();

		$tmp_data_open = [];
		$tmp_data_close = [];

		$max_order = 0;

		foreach ($order_data_arr as $key => $value) {
			if ($value->stat_total > $max_order) {
				$max_order = $value->stat_total;
			}
			$categories[] = $value->GOJEK_DESC;
			$tmp_data_open[] = [
				'y' => (int)$value->stat_open == 0 ? null : (int)$value->stat_open,
				'remark' => $this->getRemark($value->GOJEK_ID, $value->GOJEK_DESC, 'O'),
			];
			$tmp_data_close[] = [
				'y' => (int)$value->stat_close == 0 ? null : (int)$value->stat_close,
				'remark' => $this->getRemark($value->GOJEK_ID, $value->GOJEK_DESC, 'C'),
			];
		}

		$data = [
			[
				'name' => 'OPEN',
				'data' => $tmp_data_open,
				'color' => 'rgba(255, 0, 0, 0.6)'
			],
			[
				'name' => 'CLOSE',
				'data' => $tmp_data_close,
				'color' => 'rgba(0, 255, 0, 0.6)'
			],
		];

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories,
			'max_order' => $max_order,
		]);
	}

	public function getRemark($GOJEK_ID, $GOJEK_DESC, $STAT)
	{
		$data_arr = GojekOrderTbl::find()->where([
			'GOJEK_ID' => $GOJEK_ID,
			'STAT' => $STAT
		])
		->orderBy('from_loc ASC, slip_id ASC')
		->all();

		if ($STAT == 'O') {
			$status = 'OPEN';
		} else {
			$status = 'CLOSE';
		}

		$data = "<h4>Order List ($status) <small>$GOJEK_DESC</small></h4>";
		$data .= '<table class="table table-bordered table-hover">';
		$data .= 
		'<thead style="font-size: 12px;"><tr class="info">
            <th class="text-center">Slip No.</th>
            <th class="text-center">Item</th>
            <th>Item Description</th>
            <th class="text-center">From</th>
            <th class="text-center">To</th>
            <th class="text-center">Issued</th>
            <th class="text-center">Departed</th>
            <th class="text-center">Arrived</th>
		</tr></thead>';
		$data .= '<tbody style="font-size: 10px;">';

		foreach ($data_arr as $key => $value) {
			$issued = $value->issued_date == null ? '-' : date('Y-m-d H:i:s', strtotime($value->issued_date));
			$departed = $value->daparture_date == null ? '-' : date('Y-m-d H:i:s', strtotime($value->daparture_date));
			$arrived = $value->arrival_date == null ? '-' : date('Y-m-d H:i:s', strtotime($value->arrival_date));
			$data .= '
				<tr>
					<td class="text-center">' . $value->slip_id . '</td>
                    <td class="text-center">' . $value->item . '</td>
                    <td>' . $value->item_desc . '</td>
                    <td class="text-center">' . $value->from_loc . '</td>
                    <td class="text-center">' . $value->to_loc . '</td>
                    <td class="text-center">' . $issued . '</td>
                    <td class="text-center">' . $departed . '</td>
                    <td class="text-center">' . $arrived . '</td>
				</tr>
			';
		}

		$data .= '</tbody>';
		$data .= '</table>';

		return $data;
	}
}