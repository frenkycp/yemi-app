<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ProductionInspection;
use app\models\SernoCalendar;
use app\models\SernoInput;
use app\models\InspectionReportViewPercentage;

class ProductionInspectionChartController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
        date_default_timezone_set('Asia/Jakarta');

		$title = '';
		$subtitle = '';
		$data = [];
		
        $period = date('Ym');
        $inspection_report_arr = InspectionReportViewPercentage::find()
        //->where([
            //'periode' => $period
        //])
        ->orderBy('week_no, proddate')
        ->all();

        $tmp_data = [];
        foreach ($inspection_report_arr as $inspection_report) {
            $week_no = $inspection_report->week_no;
            $proddate = $inspection_report->proddate;
            $tmp_data[$week_no][$proddate]['open'] = $inspection_report->open_percentage;
            $tmp_data[$week_no][$proddate]['ok'] = $inspection_report->ok_percentage;
            $tmp_data[$week_no][$proddate]['ng'] = $inspection_report->ng_percentage;
            $tmp_data[$week_no][$proddate]['total_open'] = $inspection_report->total_no_check;
            $tmp_data[$week_no][$proddate]['total_ok'] = $inspection_report->total_ok;
            $tmp_data[$week_no][$proddate]['total_ng'] = $inspection_report->total_ng;
        }

        foreach ($tmp_data as $key => $value) {
            $tmp_category = [];
            $open_percentage_arr = [];
            $ng_percentage_arr = [];
            $ok_percentage_arr = [];
            foreach ($value as $key2 => $value2) {
                $tmp_category[] = $key2;
                $open_percentage_arr[] = [
                    'y' => (float)$value2['open']
                ];
                $ng_percentage_arr[] = [
                    'y' => (float)$value2['ng']
                ];
                $ok_percentage_arr[] = [
                    'y' => (float)$value2['ok']
                ];
            }
            $data[$key] = [
                'category' => $tmp_category,
                'data' => [
                    [
                        'name' => 'OPEN',
                        'data' => $open_percentage_arr,
                        'color' => 'rgba(10, 10, 10, 0.2)',
                    ],
                    [
                        'name' => 'NG',
                        'data' => $ng_percentage_arr,
                        'color' => 'rgba(255, 0, 0, 0.4)',
                    ],
                    [
                        'name' => 'OK',
                        'data' => $ok_percentage_arr,
                        'color' => 'rgba(0, 255, 0, 0.4)',
                    ],
                ],
            ];
        }

        $today = new \DateTime(date('Y-m-d'));
        $weekToday = $today->format("W");

		return $this->render('index', [
			'title' => $title,
			'subtitle' => $subtitle,
			'weekToday' => $weekToday,
            'data' => $data,
		]);
	}
}