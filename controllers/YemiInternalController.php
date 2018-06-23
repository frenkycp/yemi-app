<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\YemiInternalSearch;
use app\models\SernoMaster;
use app\models\SernoOutput;
use app\controllers\base\SernoOutputController;

/**
 * summary
 */
class YemiInternalController extends SernoOutputController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
    	date_default_timezone_set('Asia/Jakarta');
	    $searchModel  = new YemiInternalSearch;

	    $line_arr = ArrayHelper::map(SernoMaster::find()->select('distinct(line)')->where(['<>', 'line', ''])->orderBy('line ASC')->all(), 'line', 'line');

    	$searchModel->vms = date('Y-m-d');
    	if(\Yii::$app->request->get('vms') !== null)
    	{
    		$searchModel->vms = \Yii::$app->request->get('vms');
    	}
	    
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$vms_data = SernoOutput::find()
		->select([
			'monthly_total_plan' => 'SUM(qty)',
			'monthly_progress_plan' => 'SUM(CASE WHEN vms<=\'2018-06-23\' THEN qty ELSE 0 END)',
			'monthly_progress_output' => 'SUM(CASE WHEN vms<=\'2018-06-23\' THEN output ELSE 0 END)',
		])
		->where([
			'LEFT(vms, 7)' => date('Y-m')
		])
		->one();

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'line_arr' => $line_arr,
		    'monthly_total_plan' => $vms_data->monthly_total_plan,
		    'monthly_progress_plan' => $vms_data->monthly_progress_plan,
		    'monthly_progress_output' => $vms_data->monthly_progress_output,
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