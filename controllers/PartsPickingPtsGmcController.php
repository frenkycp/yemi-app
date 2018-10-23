<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\SapPickingListPtsView;
use app\models\SapPickingPtsDetailView;

class PartsPickingPtsGmcController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
	    $period_category = 1;
	    if(\Yii::$app->request->get('period') !== null){
	        $period_category = \Yii::$app->request->get('period');
	    }

    	$categories = [];
    	if ($period_category == 1) {
    		$start_period = date('Y') . '04';
    		$end_period = date('Y') . '09';
    	} else {
    		$start_period = date('Y') . '10';
    		$end_period = date('Y', strtotime(date('Y-m-d') . ' +1 year')) . '03';
    	}

    	$pts_data_arr = SapPickingPtsDetailView::find()
    	->select([
    		'parent',
            'parent_desc',
    		'total_count' => 'SUM(COUNT)'
    	])
    	->where(['>=', 'period', $start_period])
    	->andWhere(['<=', 'period', $end_period])
    	->groupBy('parent, parent_desc')
    	->orderBy('total_count DESC')
    	->limit(15)
        ->asArray()
    	->all();

    	$tmp_data = [];
    	foreach ($pts_data_arr as $pts_data) {
    		$categories[] = $pts_data['parent_desc'] . ' - ' . $pts_data['parent'];
    		$tmp_data[] = [
                'y' => (int)$pts_data['total_count'],
                'url' => Url::to(['get-remark', 'period_category' => $period_category, 'parent' => $pts_data['parent'], 'parent_desc' => $pts_data['parent_desc']]),
            ];
    	}

    	$data = [
    		[
    			'name' => 'Picking Trouble by Model GMC',
    			'data' => $tmp_data
    		]
    	];

    	return $this->render('index', [
    		'data' => $data,
    		'categories' => $categories,
    		'start_period' => $start_period,
    		'end_period' => $end_period,
    	]);
    }

    public function actionGetRemark($period_category, $parent, $parent_desc)
    {
        if ($period_category == 1) {
            $start_period = date('Y') . '04';
            $end_period = date('Y') . '09';
        } else {
            $start_period = date('Y') . '10';
            $end_period = date('Y', strtotime(date('Y-m-d') . ' +1 year')) . '03';
        }

        $data_arr = SapPickingPtsDetailView::find()
        ->select('child, child_desc, division, pic_delivery, req_date, req_qty, PUR_LOC_DESC')
        ->where(['>=', 'period', $start_period])
        ->andWhere(['<=', 'period', $end_period])
        ->andWhere(['parent' => $parent])
        ->orderBy('PUR_LOC_DESC, child')
        ->asArray()
        ->all();

        $remark = '<h4>PTS for ' . $parent_desc . ' - ' . $parent . ' <small>(' . date('F Y', strtotime($start_period . '01')) . ' to ' . date('F Y', strtotime($end_period . '01')) . ')</small></h4>';
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '
        <tr style="font-size: 12px;">
            <th style="text-align: center;">No</th>
            <th>Vendor</th>
            <th style="text-align: center;">Part No</th>
            <th>Part Description</th>
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
                <td>' . $value['PUR_LOC_DESC'] . '</td>
                <td style="text-align: center;">' . $value['child'] . '</td>
                <td>' . $value['child_desc'] . '</td>
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