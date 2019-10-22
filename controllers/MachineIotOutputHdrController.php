<?php

namespace app\controllers;

use app\models\MachineIotOutputDtr;
use app\models\WwStockWaitingProcess02Open;

/**
* This is the class for controller "MachineIotOutputHdrController".
*/
class MachineIotOutputHdrController extends \app\controllers\base\MachineIotOutputHdrController
{
	public function actionDetail($lot_number)
	{
        $this->layout = 'clean';
		date_default_timezone_set('Asia/Jakarta');
        $data = $tmp_data = $categories = [];

        $output_dtr = MachineIotOutputDtr::find()
        ->where([
        	'lot_number' => $lot_number
        ])
        ->orderBy('seq')
        ->all();

        $part_name = '';
        $tmp_start_date = '';
        foreach ($output_dtr as $key => $value) {
        	if ($part_name == '') {
                $part_name = $value->gmc . ' - ' . $value->gmc_desc . ' (' . $value->lot_qty . ' PCS)';
                $categories[] = $lot_number;
            }
            $lead_time = round($value->lead_time / 60);
            $minute_str = ' minute';
            if ($lead_time > 1) {
            	$minute_str = ' minutes';
            }
        	$desc = $value->mesin_id . ' - ' . $value->mesin_description . ' (' . number_format($lead_time) . $minute_str . ')';
        	if (!isset($categories[$desc])) {
        		//$categories[] = $desc;
        	}
        	$start_date = $value->start_date;
            if ($tmp_start_date == '') {
                $tmp_start_date = $start_date;
            }
        	//$tmp_start_date = date('Y-m-d 00:00:00', strtotime(time));
        	$start_date_js = strtotime($start_date . " +7 hours") * 1000;
        	$end_date = $value->end_date;
        	$end_date_js = strtotime($end_date . " +7 hours") * 1000;
        	$index = array_search($desc, $categories);
        	if ($value->status == 'RUN') {
        		$color = \Yii::$app->params['bg-green'];
        	} else {
        		$color = \Yii::$app->params['bg-gray'];
        	}
        	$tmp_data[] = [
        		//'name' => $desc,
                'x' => $start_date_js,
                'x2' => $end_date_js,
                //'y' => $index,
                'y' => 0,
                'color' => $color,
                'machine' => $desc
            ];
        }

        $lot_waiting = WwStockWaitingProcess02Open::find()
        ->where([
            'lot_number' => $lot_number
        ])
        ->one();

        if ($lot_waiting->lot_number != null) {
            $end_date = $lot_waiting->end_date;
            $end_date_js = strtotime($end_date . " +7 hours") * 1000;
            $next_process_date = $lot_waiting->next_process_date;
            $next_process_date_js = strtotime($next_process_date . " +7 hours") * 1000;
            $color = \Yii::$app->params['bg-gray'];
            $minute = round($lot_waiting->hours_waiting * 60);
            $desc = $lot_waiting->mesin_id . ' - ' . $lot_waiting->mesin_description . ' (' . $minute . ' minutes)';

            $tmp_data[] = [
                //'name' => $desc,
                'x' => $end_date_js,
                'x2' => $next_process_date_js,
                //'y' => $index,
                'y' => 0,
                'color' => $color,
                'machine' => $desc
            ];
        }

        $tmp_end_date = date('Y-m-d 24:00:00', strtotime($tmp_start_date . ' +12 days'));
        $tmp_start_date_js = strtotime($tmp_start_date . " +7 hours") * 1000;
        $tmp_end_date_js = strtotime($tmp_end_date . " +7 hours") * 1000;

        $data = [
            [
                'name' => 'Lot Timeline',
                'data' => $tmp_data,
                'showInLegend' => false,
                'pointWidth' => 20,
            ]
        ];

		return $this->render('detail', [
			'data' => $data,
			'lot_number' => $lot_number,
            'part_name' => $part_name,
            'categories' => $categories,
            'tmp_start_date_js' => $tmp_start_date_js,
            'tmp_end_date_js' => $tmp_end_date_js,
		]);
	}
}
