<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers;

use app\models\AbsensiTbl;
    use app\models\search\RekapAbsensiViewSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* HrgaAttendanceDataController implements the CRUD actions for AbsensiTbl model.
*/
class HrgaRekapAbsensiDataController extends Controller
{


	/**
	* @var boolean whether to enable CSRF validation for the actions in this controller.
	* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	*/
	public $enableCsrfValidation = false;


	/**
	* Lists all AbsensiTbl models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new RekapAbsensiViewSearch;
	    if ($searchModel->PERIOD === null) {
	    	$searchModel->PERIOD = date('Ym');
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

/**
* Displays a single AbsensiTbl model.
* @param string $NIK_DATE_ID
*
* @return mixed
*/
public function actionView($NIK_DATE_ID)
{
	\Yii::$app->session['__crudReturnUrl'] = Url::previous();
	Url::remember();
	Tabs::rememberActiveState();

	return $this->render('view', [
		'model' => $this->findModel($NIK_DATE_ID),
	]);
}

/**
* Finds the AbsensiTbl model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param string $NIK_DATE_ID
* @return AbsensiTbl the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($NIK_DATE_ID)
{
	if (($model = AbsensiTbl::findOne($NIK_DATE_ID)) !== null) {
		return $model;
	} else {
		throw new HttpException(404, 'The requested page does not exist.');
	}
}
}
