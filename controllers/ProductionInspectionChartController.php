<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoInput;
use app\models\InspectionReportViewPercentage;
use yii\web\JsExpression;

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
                    'y' => $value2['open'] == 0 ? null : (float)$value2['open'],
                    'qty' => $value2['total_open'],
                    //'remark' => $this->getRemark($key2, 'OPEN')
                ];
                $ng_percentage_arr[] = [
                    'y' => $value2['ng'] == 0 ? null : (float)$value2['ng'],
                    'qty' => $value2['total_ng'],
                    //'remark' => $this->getRemark($key2, 'NG')
                ];
                $ok_percentage_arr[] = [
                    'y' => (float)$value2['ok'],
                    'qty' => $value2['total_ok'],
                    //'remark' => $this->getRemark($key2, 'OK')
                ];
            }
            $data[$key] = [
                'category' => $tmp_category,
                'data' => [
                    [
                        'name' => 'OPEN',
                        'data' => $open_percentage_arr,
                        'color' => 'rgba(10, 10, 10, 0.2)',
                        'dataLabels' => [
                            'enabled' => false
                        ]
                    ],
                    [
                        'name' => 'NG',
                        'data' => $ng_percentage_arr,
                        'color' => 'rgba(255, 0, 0, 0.4)',
                    ],
                    [
                        'name' => 'OK',
                        'data' => $ok_percentage_arr,
                        //'color' => 'rgba(0, 255, 0, 0.4)',
                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
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

    public function getRemark($tgl)
    {

        $serno_input_arr = SernoInput::find()
        ->where([
            'proddate' => $tgl
        ])
        ->all();

        $data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<tr class="info">
            <th class="text-center">No</th>
            <th class="text-center">Prod. Date</th>
            <th class="text-center">GMC</th>
            <th class="text-center">Serial No</th>
            <th class="text-center">NG Date</th>
            <th class="text-center">NG</th>
            <th class="text-center">OK Date</th>
        </tr>';

        $i = 1;
        foreach ($serno_input_arr as $serno_input) {
            $data .= '
                <tr>
                    <td class="text-center">' . $i .'</td>
                    <td class="text-center">' . $serno_input->proddate .'</td>
                    <td class="text-center">' . $serno_input->gmc .'</td>
                    <td class="text-center">' . $serno_input->sernum .'</td>
                    <td class="text-center">' . $serno_input->qa_ng_date .'</td>
                    <td class="text-center">' . $serno_input->qa_ng .'</td>
                    <td class="text-center">' . $serno_input->qa_ok_date .'</td>
                </tr>
            ';
            $i++;
        }

        $data .= '</table>';

        return $data;
    }
}