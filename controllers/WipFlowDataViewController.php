<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\WipFlowDataViewSearch;
use app\models\WipFlowView02;

class WipFlowDataViewController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$searchModel  = new WipFlowDataViewSearch;
		if(\Yii::$app->request->get('location') !== null){
			$searchModel->child_analyst_desc = \Yii::$app->request->get('location');
		}
		if(\Yii::$app->request->get('period') !== null){
			$searchModel->period = \Yii::$app->request->get('period');
		}
		if(\Yii::$app->request->get('group_model') !== null){
			$searchModel->model_group = \Yii::$app->request->get('group_model');
		}
		if(\Yii::$app->request->get('gmc') !== null){
			$searchModel->parent = \Yii::$app->request->get('gmc');
		}
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$loc_arr = ArrayHelper::map(WipFlowView02::find()->select('DISTINCT(child_analyst_desc)')->orderBy('child_analyst_desc')->all(), 'child_analyst_desc', 'child_analyst_desc');

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'loc_arr' => $loc_arr,
		]);
	}
}