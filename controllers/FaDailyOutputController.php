<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\search\FaDailyOutputSearch;
use dmstr\bootstrap\Tabs;

class FaDailyOutputController extends Controller
{
	public function actionIndex()
	{
		$searchModel  = new FaDailyOutputSearch;
    	$searchModel->proddate = date('Y-m-d');
    	if (\Yii::$app->request->get('proddate') !== null) {
			$searchModel->proddate = \Yii::$app->request->get('proddate');
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
}