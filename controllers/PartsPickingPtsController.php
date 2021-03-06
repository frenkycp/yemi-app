<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\SapPickingListPtsView;
use app\models\SapPickingPtsDetailView;

class PartsPickingPtsController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {

	    $period_category = 1;
        $year = date('Y');
        if (date('n') < 4) {
            $year--;
            $period_category = 2;
        }
	    if(\Yii::$app->request->get('period') !== null){
	        $period_category = \Yii::$app->request->get('period');
	    }

    	$categories = [];
    	if ($period_category == 1) {
    		$start_period = $year . '04';
    		$end_period = $year . '09';
    	} else {
    		$start_period = $year . '10';
    		$end_period = ($year + 1) . '03';
    	}

    	$pts_data_arr = SapPickingPtsDetailView::find()
    	->select([
    		'PUR_LOC_DESC',
    		'total_count' => 'SUM(COUNT)'
    	])
    	->where(['>=', 'period', $start_period])
    	->andWhere(['<=', 'period', $end_period])
    	->groupBy('PUR_LOC_DESC')
    	->orderBy('total_count DESC')
    	->limit(15)
        ->asArray()
    	->all();

    	$tmp_data = [];
    	foreach ($pts_data_arr as $pts_data) {
    		$categories[] = $pts_data['PUR_LOC_DESC'];
    		$tmp_data[] = [
                'y' => (int)$pts_data['total_count'],
                'url' => Url::to(['get-remark', 'start_period' => $start_period, 'end_period' => $end_period, 'pur_loc_desc' => $pts_data['PUR_LOC_DESC']]),
            ];
    	}

    	$data = [
    		[
    			'name' => 'Picking Trouble by Vendor',
    			'data' => $tmp_data
    		]
    	];

    	return $this->render('index', [
    		'data' => $data,
    		'categories' => $categories,
    		'start_period' => $start_period,
    		'end_period' => $end_period,
            'period_category' => $period_category,
    	]);
    }

    public function actionGetRemark($start_period, $end_period, $pur_loc_desc)
    {
        $data_arr = SapPickingPtsDetailView::find()
        ->select('parent, parent_desc, child, child_desc, division, pic_delivery, req_date, req_qty')
        ->where(['>=', 'period', $start_period])
        ->andWhere(['<=', 'period', $end_period])
        ->andWhere(['PUR_LOC_DESC' => $pur_loc_desc])
        ->orderBy('child DESC, parent')
        ->asArray()
        ->all();

        $remark = '<h4>PTS by ' . $pur_loc_desc . ' <small>(' . date('F Y', strtotime($start_period . '01')) . ' to ' . date('F Y', strtotime($end_period . '01')) . ')</small></h4>';
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '
        <tr style="font-size: 12px;">
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Part No</th>
            <th>Part Description</th>
            <th style="text-align: center;">Parent</th>
            <th>Parent Description</th>
            <th style="text-align: center;">Division</th>
            <th style="text-align: center;">Request<br/>Date</th>
            <th style="text-align: center;">Request<br/>Qty</th>
        </tr>
        ';

        $no = 1;
        foreach ($data_arr as $value) {
            $req_date = $value['req_date'] == null ? '-' : date('Y-m-d', strtotime($value['req_date']));
            $remark .= '
            <tr style="font-size: 12px;">
                <td style="text-align: center;">' . $no . '</td>
                <td style="text-align: center;">' . $value['child'] . '</td>
                <td>' . $value['child_desc'] . '</td>
                <td style="text-align: center;">' . $value['parent'] . '</td>
                <td>' . $value['parent_desc'] . '</td>
                <td style="text-align: center;">' . $value['division'] . '</td>
                <td style="text-align: center; min-width: 90px;">' . $req_date . '</td>
                <td style="text-align: center; min-width: 90px;">' . (int)$value['req_qty'] . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';

        return $remark;
    }
}