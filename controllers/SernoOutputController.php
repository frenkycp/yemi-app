<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ContainerView;
use yii\helpers\Url;

class SernoOutputController extends base\SernoOutputController
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionReport()
    {
        return $this->render('report');
    }

    public function actionContainerProgress()
    {
    	$etd = \Yii::$app->request->get('etd');
    	$container = ContainerView::find()->where(['etd' => $etd])->all();

		foreach ($container as $key => $value) {
			$close_percentage = (int)floor(($value->output / $value->qty) * 100);
			$open_percentage = (int)(100 - $close_percentage);
			$dataOpen[] = [
				'y' => $open_percentage,
				'qty' => $value->balance,
				'url' => Url::to(['index', 'index_type' => 1, 'etd' => $value->etd, 'stc' => $value->stc]),
			];
            $dataClose[] = [
				'y' => $close_percentage,
				'qty' => $value->output,
				'url' => Url::to(['index', 'index_type' => 2, 'etd' => $value->etd, 'stc' => $value->stc]),
			];
            //$dataOpen[] = 50;
            //$dataClose[] = 50;
            $str_container = '_container)';
            if($value->total_cntr > 1)
            {
            	$str_container = '_containers)';
            }
            $dataName[] = $value->customer_desc . ' (' . $value->total_cntr . $str_container;
		}
		//return json_encode($dataOpen);

    	return $this->render('container-progress', [
    		'dataOpen' => $dataOpen,
    		'dataClose' => $dataClose,
    		'dataName' => $dataName
    	]);
    }
}