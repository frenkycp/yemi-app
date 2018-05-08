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
    	$container = ContainerView::find()->where(['etd' => $etd])->orderBy('dst ASC')->all();

		foreach ($container as $key => $value) {
			$close_percentage = (int)floor(($value->output / $value->qty) * 100);
			$open_percentage = (int)(100 - $close_percentage);
			$dataOpen[] = [
				'y' => $open_percentage,
				'qty' => $value->balance,
				'url' => Url::to(['index', 'index_type' => 1, 'etd' => $value->etd, 'dst' => $value->dst]),
			];
            $dataClose[] = [
				'y' => $close_percentage,
				'qty' => $value->output,
				'url' => Url::to(['index', 'index_type' => 2, 'etd' => $value->etd, 'dst' => $value->dst]),
			];
            //$dataOpen[] = 50;
            //$dataClose[] = 50;
            $str_container = '_container)';
            if($value->total_cntr > 1)
            {
            	$str_container = '_containers)';
            }
            $dataName[] = $value->dst . ' (' . $value->total_cntr . $str_container;
		}
		//return json_encode($dataOpen);

    	return $this->render('container-progress', [
    		'dataOpen' => $dataOpen,
    		'dataClose' => $dataClose,
    		'dataName' => $dataName
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