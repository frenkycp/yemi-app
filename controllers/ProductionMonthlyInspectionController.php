<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\InspectionReportView;
use app\models\SernoInput;
use yii\helpers\Url;

/**
 * summary
 */
class ProductionMonthlyInspectionController extends Controller
{
    public function actionIndex()
    {
    	$periode = date('Ym');
    	$categories = [];

    	$inspection_data_arr = InspectionReportView::find()
    	->where([
    		'periode' => $periode
    	])
    	->andWhere(['>', 'total_ng', 0])
    	->orderBy('proddate')
    	->all();

    	$tmp_data = [];
    	foreach ($inspection_data_arr as $inspection_data) {
    		$categories[] = $inspection_data->proddate;
    		
    		$tmp_data[] = [
    			'y' => (int)$inspection_data->total_ng,
    			'url' => Url::to(['serno-input/index', 'proddate' => $inspection_data->proddate, 'status' => 'NG']),
    			//'remark' => $this->getNgDataRemark($inspection_data->proddate)
    		];
    	}

    	$data = [
    		[
    			'name' => 'NG Product',
    			'data' => $tmp_data
    		]
    	];

    	return $this->render('index', [
    		'data' => $data,
    		'categories' => $categories
    	]);
    }

    public function getNgDataRemark($proddate)
    {
    	$detail_data_arr = SernoInput::find()
    	->where([
    		'proddate' => $proddate
    	])
    	->andWhere(['<>', 'qa_ng', ''])
    	->all();

    	$data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<tr class="info">
            <th class="text-center">Prod. Date</th>
            <th class="text-center">Line</th>
            <th class="text-center">GMC</th>
            <th class="text-center">Serial No.</th>
            <th class="text-center">NG Remark</th>
            <th class="text-center">NG Date</th>
        </tr>';

        foreach ($detail_data_arr as $detail_data) {
    	$data .= '
            <tr>
                <td class="text-center">' . $detail_data->proddate .'</td>
                <td class="text-center">' . $detail_data->line .'</td>
                <td class="text-center">' . $detail_data->gmc .'</td>
                <td class="text-center">' . $detail_data->sernum .'</td>
                <td class="text-center">' . $detail_data->qa_ng .'</td>
                <td class="text-center">' . $detail_data->qa_ng_date .'</td>
            </tr>
        ';
        }

        $data .= '</table>';

        return $data;
    }
}