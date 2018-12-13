<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\SupplementDailyProgressView;
use app\models\SupplementDetailView;

class PartSupplementDailyCompletionController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}
		$period = $year . $month;

		$supplement_data_arr = SupplementDailyProgressView::find()
		->where([
			'period' => $period
		])
		->orderBy('date_spt ASC')
		->asArray()->all();

		foreach ($supplement_data_arr as $key => $supplement_data) {
			$proddate = (strtotime($supplement_data['date_spt'] . " +7 hours") * 1000);
			$tmp_data_request[] = [
				'x' => $proddate,
				'y' => $supplement_data['request_qty'] == 0 ? null : (int)$supplement_data['request_qty'],
				'qty' => (int)$supplement_data['request_qty'],
				'url' => Url::to(['get-supplement-detail', 'issued_date' => $supplement_data['date_spt'], 'status' => 0])
			];
			$tmp_data_pc_approved[] = [
				'x' => $proddate,
				'y' => $supplement_data['pc_approved_qty'] == 0 ? null : (int)$supplement_data['pc_approved_qty'],
				'qty' => (int)$supplement_data['pc_approved_qty'],
				'url' => Url::to(['get-supplement-detail', 'issued_date' => $supplement_data['date_spt'], 'status' => 1])
			];
			$tmp_data_pc_rejected[] = [
				'x' => $proddate,
				'y' => $supplement_data['pc_rejected_qty'] == 0 ? null : (int)$supplement_data['pc_rejected_qty'],
				'qty' => (int)$supplement_data['pc_rejected_qty'],
				'url' => Url::to(['get-supplement-detail', 'issued_date' => $supplement_data['date_spt'], 'status' => 4])
			];
			$tmp_data_reject_history[] = [
				'x' => $proddate,
				'y' => $supplement_data['reject_history_qty'] == 0 ? null : (int)$supplement_data['reject_history_qty'],
				'qty' => (int)$supplement_data['reject_history_qty'],
				'url' => Url::to(['get-supplement-detail', 'issued_date' => $supplement_data['date_spt'], 'status' => 7])
			];
			$tmp_data_wh_approved[] = [
				'x' => $proddate,
				'y' => $supplement_data['wh_approved_qty'] == 0 ? null : (int)$supplement_data['wh_approved_qty'],
				'qty' => (int)$supplement_data['wh_approved_qty'],
				'url' => Url::to(['get-supplement-detail', 'issued_date' => $supplement_data['date_spt'], 'status' => 2])
			];
			$tmp_data_outstanding[] = [
				'x' => $proddate,
				'y' => $supplement_data['outstanding_qty'] == 0 ? null : (int)$supplement_data['outstanding_qty'],
				'qty' => (int)$supplement_data['outstanding_qty'],
				'url' => Url::to(['get-supplement-detail', 'issued_date' => $supplement_data['date_spt'], 'status' => 6])
			];
			$tmp_data_wh_rejected[] = [
				'x' => $proddate,
				'y' => $supplement_data['wh_rejected_qty'] == 0 ? null : (int)$supplement_data['wh_rejected_qty'],
				'qty' => (int)$supplement_data['wh_rejected_qty'],
				'url' => Url::to(['get-supplement-detail', 'issued_date' => $supplement_data['date_spt'], 'status' => 5])
			];
			$tmp_data_pulled_up[] = [
				'x' => $proddate,
				'y' => $supplement_data['pulled_up_qty'] == 0 ? null : (int)$supplement_data['pulled_up_qty'],
				'qty' => (int)$supplement_data['pulled_up_qty'],
				'url' => Url::to(['get-supplement-detail', 'issued_date' => $supplement_data['date_spt'], 'status' => 3])
			];
		}

		$data = [
			[
				'name' => 'Order',
				'data' => $tmp_data_request
			],
			[
				'name' => 'PC Approved',
				'data' => $tmp_data_pc_approved
			],
			[
				'name' => 'PC Rejected',
				'data' => $tmp_data_pc_rejected
			],
			[
				'name' => 'PC Rejected (History)',
				'data' => $tmp_data_reject_history
			],
			[
				'name' => 'WH Approved',
				'data' => $tmp_data_wh_approved
			],
			[
				'name' => 'Outstanding',
				'data' => $tmp_data_outstanding
			],
			[
				'name' => 'WH Rejected',
				'data' => $tmp_data_wh_rejected
			],
			[
				'name' => 'Pulled Up',
				'data' => $tmp_data_pulled_up
			],
		];

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function actionGetSupplementDetail($issued_date, $status)
	{
		$status_desc = '';
		if ($status == 0) {
			$status_desc = 'Order';
		} elseif ($status == 1) {
			$status_desc = 'PC Approved';
		} elseif ($status == 2) {
			$status_desc = 'WH Approved';
		} elseif ($status == 3) {
			$status_desc = 'Pulled Up';
		} elseif ($status == 4) {
			$status_desc = 'PC Rejected';
		} elseif ($status == 5) {
			$status_desc = 'WH Rejected';
		} elseif ($status == 6) {
			$status_desc = 'Outstanding';
		} elseif ($status == 7) {
			$status_desc = 'PC Rejected (History)';
		}
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Status : ' . $status_desc . ' <small>(' . date('d M\' Y') . ')</small></h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th class="text-center" style="min-width: 70px;">Slip Num.</th>
	    	<th class="text-center">Line</th>
	    	<th class="text-center">Part Num.</th>
	    	<th>Part Description</th>
	    	<th class="text-center">Request<br/>Qty</th>
	    	<th class="text-center">Reason</th>
	    	<th>PC Remark</th>
	    	<th>WH Remark</th>
	    </tr>';

	    $detail_data_arr = SupplementDetailView::find()
		->where([
			'date_Spt' => $issued_date,
			'stts_req' => $status
		])
		->asArray()
		->all();

		foreach ($detail_data_arr as $key => $detail_data) {
			$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . $detail_data['slip_spt'] . '</td>
	    		<td class="text-center">' . $detail_data['nm_line'] . '</td>
	    		<td class="text-center">' . $detail_data['part_numb'] . '</td>
	    		<td>' . $detail_data['description'] . '</td>
	    		<td class="text-center">' . $detail_data['total_req'] . '</td>
	    		<td class="text-center">' . $detail_data['reason'] . '</td>
	    		<td>' . $detail_data['remarks_pc'] . '</td>
	    		<td>' . $detail_data['remarks_wh'] . '</td>
	    	</tr>';
	    	$no++;
		}

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}