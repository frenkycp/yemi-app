<?php

namespace app\controllers;

use app\models\search\MitaUrlSearch;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class MitaUrlController extends \app\controllers\base\MitaUrlController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
	    $searchModel  = new MitaUrlSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}
}
