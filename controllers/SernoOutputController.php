<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ContainerView;
use app\models\SernoOutput;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\SernoOutput as SernoOutputSearch;
use app\models\SernoCalendar;

class SernoOutputController extends base\SernoOutputController
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
	    $searchModel  = new SernoOutputSearch;
	    $searchModel->etd = date('Y-m');
	    if(\Yii::$app->request->get('etd') !== null)
	    {
	    	$searchModel->etd = \Yii::$app->request->get('etd');
	    }
        if(\Yii::$app->request->get('back_order') !== null)
        {
            $searchModel->back_order = \Yii::$app->request->get('back_order');
        }
	    
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
		  'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}
    
    public function actionReport()
    {
    	date_default_timezone_set('Asia/Jakarta');
        $year = date('Y');
        $month = date('m');

        if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;

    	/*$min_max_week = SernoOutput::find()
    	->select([
    		'EXTRACT(YEAR_MONTH FROM etd)',
    		'min_week' => 'MIN(WEEK(ship,4))',
    		'max_week' => 'MAX(WEEK(ship,4))'
    	])
    	->where(['<>', 'stc', 'ADVANCE'])
        ->andWhere(['EXTRACT(YEAR_MONTH FROM etd)' => $period])
    	->groupBy('EXTRACT(YEAR_MONTH FROM etd)')
    	->one();*/
        $todays_week = 0;
    	$weekToday = SernoCalendar::find()->where([
            'etd' => date('Y-m-d'),
            'EXTRACT(year_month FROM etd)' => $period
        ])->one()->week_ship;
        $tmp_week_arr = SernoCalendar::find()->select('week_ship')->where(['EXTRACT(year_month FROM etd)' => $period])->groupBy('week_ship')->orderBy('etd')->all();

        foreach ($tmp_week_arr as $key => $value) {
            if ($todays_week == 0) {
                $todays_week = $value->week_ship;
            }

            if ($weekToday == $value->week_ship) {
                $todays_week = $value->week_ship;
            }
        }

        $week_data_arr = ArrayHelper::map(SernoCalendar::find()
            ->where([
            '>=', 'EXTRACT(year_month FROM etd)', $period
        ])->all(), 'etd', 'week_ship');

        /*$start_week = 0;
        $end_week = 0;
        if(count($min_max_week) > 0)
        {
            $start_week = $min_max_week->min_week;
            $end_week = $min_max_week->max_week;
        }*/

        /*if (!$weekToday) {
            $weekToday = $start_week;
        }*/

        return $this->render('report',[
        	'weekToday' => $weekToday,
            'todays_week' => $todays_week,
        	'startWeek' => $start_week,
        	'endWeek' => $end_week,
            'year' => $year,
            'month' => $month,
            'period' => $period,
            'week_data_arr' => $week_data_arr,
            'tmp_week_arr' => $tmp_week_arr,
        ]);
    }

    public function actionContainerProgress()
    {
    	$etd = \Yii::$app->request->get('etd');
    	$container = ContainerView::find()->where(['etd' => $etd])->orderBy('dst ASC')->all();
    	$total_container = 0;
        $total_airshipment = 0;

		foreach ($container as $key => $value) {
            $close_percentage = 0;
            if ($value->qty > 0) {
                $close_percentage = (int)floor(($value->output / $value->qty) * 100);
            }
			
			$open_percentage = (int)(100 - $close_percentage);
			$dataOpen[] = [
				'y' => $open_percentage > 0 ? $open_percentage : null,
				'qty' => $value->balance,
				'url' => Url::to(['index', 'index_type' => 1, 'etd' => $value->etd, 'dst' => $value->dst, 'back_order' => $value->back_order]),
			];
            $dataClose[] = [
				'y' => $close_percentage > 0 ? $close_percentage : null,
				'qty' => $value->output,
				'url' => Url::to(['index', 'index_type' => 2, 'etd' => $value->etd, 'dst' => $value->dst, 'back_order' => $value->back_order]),
			];
            //$dataOpen[] = 50;
            //$dataClose[] = 50;
            $str_container = '_container)';
            if ($value->back_order == 2) {
                $str_container = '_airshipment)';
            }
            $str_airplane = '_airplane';
            if($value->total_cntr > 1)
            {
            	$str_container = '_containers)';
                if ($value->back_order == 2) {
                    $str_container = '_airshipments)';
                }
            }
            $total_container += $value->back_order != 2 ? $value->total_cntr : 0;
            $total_airshipment += $value->back_order == 2 ? $value->total_cntr : 0;
            $dataName[] = $value->dst . ' (' . $value->total_cntr . $str_container;
		}
		//return json_encode($dataOpen);
		$containerStr = $total_container . ' Container || ' . $total_airshipment . ' Air Shipment';
		if($total_container > 1)
		{
			$containerStr = $total_container . ' Containers || ' . $total_airshipment . ' Air Shipments';
		}

    	return $this->render('container-progress', [
    		'dataOpen' => $dataOpen,
    		'dataClose' => $dataClose,
    		'dataName' => $dataName,
    		'containerStr' => $containerStr
    	]);
    }

    public function actionUpdate($pk)
	{
		$model = $this->findModel($pk);

		if ($model->load($_POST)) {
			if($model->category == ''){
				$model->remark = '';
			}
			if($model->save()){
				return $this->redirect(Url::previous());
			}else{
				return json_encode($model->errors);
			}
			
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}