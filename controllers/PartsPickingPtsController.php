<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\SapPickingListPtsView;

class PartsPickingPtsController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$model = new \yii\base\DynamicModel([
	        'period'
	    ]);
	    $model->addRule(['period'], 'required');

	    $period_category = 1;
	    if($model->load(\Yii::$app->request->get())){
	        $period_category = $model->period;
	    }

    	$categories = [];
    	if ($period_category == 1) {
    		$start_period = date('Y') . '04';
    		$end_period = date('Y') . '09';
    	} else {
    		$start_period = date('Y') . '10';
    		$end_period = date('Y', strtotime(date('Y-m-d') . ' +1 year')) . '03';
    	}

    	$pts_data_arr = SapPickingListPtsView::find()
    	->select([
    		'PUR_LOC_DESC',
    		'total_count' => 'SUM(COUNT)'
    	])
    	->where(['>=', 'period', $start_period])
    	->andWhere(['<=', 'period', $end_period])
    	->groupBy('PUR_LOC_DESC')
    	->orderBy('total_count DESC')
    	->limit(10)
    	->all();

    	$tmp_data = [];
    	foreach ($pts_data_arr as $pts_data) {
    		$categories[] = $pts_data->PUR_LOC_DESC;
    		$tmp_data[] = (int)$pts_data->total_count;
    	}

    	$data = [
    		[
    			'name' => 'Total PTS',
    			'data' => $tmp_data
    		]
    	];

    	return $this->render('index', [
    		'data' => $data,
    		'model' => $model,
    		'categories' => $categories,
    		'start_period' => $start_period,
    		'end_period' => $end_period,
    	]);
    }
}