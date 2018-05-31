<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoOutput;
use yii\helpers\Url;

class YemiInternalContainerController extends Controller
{
	public function actionIndex()
	{
		$vms = \Yii::$app->request->get('vms');
    	$container = SernoOutput::find()
    	->select('id, vms, WEEK(ship, 4) AS `week_no`, dst, SUM(qty) AS qty, SUM(output) AS output, (SUM(output) - SUM(qty)) as `balance`, COUNT(cntr) as `total_cntr`')
    	->where(['vms' => $vms])
    	->groupBy('id, week_no, vms, dst')
    	->orderBy('dst ASC')
    	->all();
    	$total_container = 0;

		foreach ($container as $key => $value) {
			$close_percentage = (int)floor(($value->output / $value->qty) * 100);
			$open_percentage = (int)(100 - $close_percentage);
			$dataOpen[] = [
				'y' => $open_percentage,
				'qty' => $value->balance,
				'url' => Url::to(['/yemi-internal/index', 'index_type' => 1, 'vms' => $value->vms, 'dst' => $value->dst]),
			];
            $dataClose[] = [
				'y' => $close_percentage,
				'qty' => $value->output,
				'url' => Url::to(['/yemi-internal/index', 'index_type' => 2, 'vms' => $value->vms, 'dst' => $value->dst]),
			];
            //$dataOpen[] = 50;
            //$dataClose[] = 50;
            $str_container = '_container)';
            if($value->total_cntr > 1)
            {
            	$str_container = '_containers)';
            }
            $total_container += $value->total_cntr;
            $dataName[] = $value->dst . ' (' . $value->total_cntr . $str_container;
		}
		//return json_encode($dataOpen);
		$containerStr = $total_container . ' Container';
		if($total_container > 1)
		{
			$containerStr = $total_container . ' Containers';
		}

    	return $this->render('index', [
    		'dataOpen' => $dataOpen,
    		'dataClose' => $dataClose,
    		'dataName' => $dataName,
    		'containerStr' => $containerStr
    	]);
	}
}