<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\MachineIotOutputSearch;
use app\models\MachineIotCurrent;

/**
* This is the class for controller "MachineIotOutputController".
*/
class MachineIotOutputController extends \app\controllers\base\MachineIotOutputController
{
	public function actionIndex()
	{
	    $searchModel  = new MachineIotOutputSearch;

	    /*$tmp_kelompok_arr = [];
	    if(\Yii::$app->request->get('child_analyst') !== null && \Yii::$app->request->get('child_analyst') != '')
	    {
	    	$drop_down_kelompok = ArrayHelper::map(MachineIotCurrent::find()->select('kelompok')->where(['child_analyst' => \Yii::$app->request->get('child_analyst')])->groupBy('kelompok')->orderBy('kelompok')->all(), 'kelompok', 'kelompok');
	    } else {
	    	$drop_down_kelompok = ArrayHelper::map(MachineIotCurrent::find()->select('kelompok')->groupBy('kelompok')->orderBy('kelompok')->all(), 'kelompok', 'kelompok');
	    }*/

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    //'drop_down_kelompok' => $drop_down_kelompok,
		]);
	}
}
