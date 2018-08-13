<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoOutput;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\PlanReceivingPeriod;
use yii\helpers\Html;

class ProductionContainerDailyReportController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
    	$data = [];
    	$category = [];
    	//$title = date('F Y');
    	$subtitle = '';
    	$year_arr = [];
		$month_arr = [];

		for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = SernoOutput::find()->select('MIN(CAST(LEFT(etd,4) as UNSIGNED)) as `min_year`')->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

    	$model = new PlanReceivingPeriod();
		$model->month = date('m');
		$model->year = date('Y');
		if ($model->load($_POST))
		{

		}

    	$data_arr = SernoOutput::find()
    	->select([
    		'etd' => 'etd',
    		'cntr' => 'cntr',
    		'total_qty' => 'SUM(qty)',
    		'total_output' => 'SUM(output)'
    	])
    	->where([
    		'LEFT(etd, 7)' => $model->year . '-' . $model->month,
    	])
        ->andWhere(['<>', 'back_order', 2])
    	->groupBy('etd, cntr')
    	->orderBy('etd, cntr')
    	->all();

    	foreach ($data_arr as $value) {
    		if (!isset($data[$value->etd]['total_open'])) {
    			$data[$value->etd]['total_open'] = 0;
    		}
    		if (!isset($data[$value->etd]['total_close'])) {
    			$data[$value->etd]['total_close'] = 0;
    		}
    		if ($value->total_qty != $value->total_output) {
    			$data[$value->etd]['total_open']++;
    		} else {
    			$data[$value->etd]['total_close']++;
    		}
    	}

    	$presentase_open_arr = [];
    	$presentase_close_arr = [];
        $total_container = 0;

    	foreach ($data as $key => $value) {
    		$category[] = $key;
    		$data_open = $value['total_open'];
    		$data_close = $value['total_close'];
    		$data_total = $data_open + $data_close;
            $total_container += $data_total;

    		$presentase_open = 0;
    		$presentase_close = 0;
    		if ($data_total > 0) {
    			$presentase_open = round((($data_open / $data_total) * 100), 2);
    			$presentase_close = round((($data_close / $data_total) * 100), 2);
    		}

            $remark = $this->getRemark($key);

    		$presentase_open_arr[] = [
    			'y' => $presentase_open,
    			'qty' => $data_open,
    			'total_qty' => $data_total,
                'remark' => $remark,
    		];
    		$presentase_close_arr[] = [
    			'y' => $presentase_close,
    			'qty' => $data_close,
    			'total_qty' => $data_total,
                'remark' => $remark,
    		];
    	}

    	$final_data = [
    		[
    			'name' => 'OPEN',
    			'data' => $presentase_open_arr,
    			'dataLabels' => [
    				'enabled' => false
    			],
    			'color' => 'rgba(200, 200, 200, 0.4)',
    			'showInLegend' => false,
    		],[
    			'name' => 'CLOSE',
    			'data' => $presentase_close_arr,
    			'color' => 'rgba(72,61,139,0.6)',
    			'showInLegend' => false,
    		]
    	];

        $serno_output_arr = SernoOutput::find()
        ->where([
            'LEFT(etd, 7)' => $model->year . '-' . $model->month
        ])
        ->groupBy('dst, cntr')
        ->orderBy('dst, cntr')
        ->all();

        $tmp_data2 = [];
        foreach ($serno_output_arr as $serno_output) {
            if (!isset($tmp_data2[$serno_output->dst]['total_container'])) {
                $tmp_data2[$serno_output->dst]['total_container'] = 0;
            }
            $tmp_data2[$serno_output->dst]['total_container']++;
        }

        $category2 = [];
        $final_data2 = [];
        arsort($tmp_data2);
        foreach ($tmp_data2 as $key => $value) {
            $category2[] = $key;
            $final_data2[] = (int)$value['total_container'];
        }

    	return $this->render('index', [
    		'model' => $model,
    		'data' => $final_data,
            'data2' => $final_data2,
    		'category' => $category,
            'category2' => $category2,
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'month_arr' => $month_arr,
    		'year_arr' => $year_arr,
            'total_container' => $total_container
    	]);
    }

    public function getRemark($etd)
    {
        $data = '<table class="table table-bordered table-hover">';
        $data .= 
        '<tr class="info">
            <th class="text-center">No.</th>
            <th class="text-center">Container ID</th>
            <th class="text-center">SO Number</th>
            <th>Port</th>
            <th class="text-center">Invoice Num.</th>
            <th class="text-center">Container Num.</th>
            <th class="text-center">M3</th>
            <th class="text-center">Evidence File</th>
        </tr>';

        $serno_output_arr = SernoOutput::find()
        ->where([
            'etd' => $etd
        ])
        ->groupBy('cntr')
        ->orderBy('cntr')
        ->all();

        $no = 1;

        foreach ($serno_output_arr as $serno_output) {
            $filename = $serno_output['cntr'] . '.pdf';
            $path = \Yii::$app->basePath . '\\..\\mis7\\fg\\' . $filename;
            $link = '-';
            if (file_exists($path)) {
                $link = Html::a($filename, 'http://172.17.144.6:99/fg/' . $filename, ['target' => '_blank']);
            }
            $data .= '
                <tr class="' . $class . '">
                    <td class="text-center">' . $no . '</td>
                    <td class="text-center">' . $serno_output['cntr'] . '</td>
                    <td class="text-center">' . $serno_output['so'] . '</td>
                    <td>' . $serno_output['dst'] . '</td>
                    <td class="text-center">' . $serno_output['invo'] . '</td>
                    <td class="text-center">' . $serno_output['cont'] . '</td>
                    <td class="text-center">' . $serno_output['m3'] . '</td>
                    <td class="text-center">' . $link . '</td>
                </tr>
            ';
            $no++;
        }

        $data .= '</table>';
        return $data;
    }
}