<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\SunfishAttendanceDataSearch;

class SunfishAttendanceDataController extends Controller
{
	
	public function actionIndex()
	{
	    $searchModel  = new SunfishAttendanceDataSearch;
	    $searchModel->post_date = date('Y-m-d');
        if (\Yii::$app->request->post('post_date') !== null) {
            $searchModel->post_date = Yii::$app->request->post('post_date');
        }
        $searchModel->period = date('Ym');
        if (\Yii::$app->request->post('period') !== null) {
            $searchModel->period = Yii::$app->request->post('period');
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