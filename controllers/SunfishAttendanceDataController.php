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
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

	    $searchModel  = new SunfishAttendanceDataSearch;
	    $searchModel->post_date = date('Y-m-d');
	    if (isset($_GET['post_date'])) {
	    	$searchModel->post_date = $_GET['post_date'];
	    }
	    if (isset($_GET['shift'])) {
	    	$searchModel->shift = $_GET['shift'];
	    }
	    if (isset($_GET['attend_judgement'])) {
	    	$searchModel->attend_judgement = $_GET['attend_judgement'];
	    }
        if (\Yii::$app->request->post('post_date') !== null) {
            $searchModel->post_date = Yii::$app->request->post('post_date');
        }
        /*$searchModel->period = date('Ym');
        if (\Yii::$app->request->post('period') !== null) {
            $searchModel->period = Yii::$app->request->post('period');
        }*/
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