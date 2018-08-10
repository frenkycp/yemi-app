<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ContainerView;
use app\models\SernoOutput;
use yii\helpers\Url;
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

    	$min_max_week = SernoOutput::find()
    	->select([
    		'tahun' => 'LEFT(id,4)',
    		'min_week' => 'MIN(WEEK(ship,4))',
    		'max_week' => 'MAX(WEEK(ship,4))'
    	])
    	->where(['<>', 'stc', 'ADVANCE'])
    	//->andWhere(['<>', 'stc', 'NOSO'])
    	//->andWhere(['LEFT(id,4)' => date('Y')])
    	//->andWhere(['<>', 'ship', '9999-12-31'])
    	->groupBy('tahun')
    	->one();

    	$weekToday = SernoCalendar::find()->where(['etd' => date('Y-m-d')])->one()->week_ship;

        $start_week = 1;
        $end_week = 52;

        if(count($min_max_week) > 0)
        {
            $start_week = $min_max_week->max_week - 12;
            $end_week = $min_max_week->max_week;
        }

        return $this->render('report',[
        	'weekToday' => $weekToday,
        	'startWeek' => $start_week,
        	'endWeek' => $end_week
        ]);
    }

    public function actionContainerProgress()
    {
    	$etd = \Yii::$app->request->get('etd');
    	$container = ContainerView::find()->where(['etd' => $etd])->orderBy('dst ASC')->all();
    	$total_container = 0;
        $total_airshipment = 0;

		foreach ($container as $key => $value) {
			$close_percentage = (int)floor(($value->output / $value->qty) * 100);
			$open_percentage = (int)(100 - $close_percentage);
			$dataOpen[] = [
				'y' => $open_percentage,
				'qty' => $value->balance,
				'url' => Url::to(['index', 'index_type' => 1, 'etd' => $value->etd, 'dst' => $value->dst, 'back_order' => $value->back_order]),
			];
            $dataClose[] = [
				'y' => $close_percentage,
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