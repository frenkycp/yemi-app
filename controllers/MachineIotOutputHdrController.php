<?php

namespace app\controllers;

use app\models\MachineIotOutputDtr;

/**
* This is the class for controller "MachineIotOutputHdrController".
*/
class MachineIotOutputHdrController extends \app\controllers\base\MachineIotOutputHdrController
{
	public function actionDetail($lot_number)
	{
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
		]);
	}
}
