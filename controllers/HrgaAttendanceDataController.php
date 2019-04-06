<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\HrgaAttendanceDataSearch;

class HrgaAttendanceDataController extends \app\controllers\base\HrgaAttendanceDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    /**
	* Lists all AbsensiTbl models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new HrgaAttendanceDataSearch;
	    $searchModel->DATE = date('Y-m-d');
        if (\Yii::$app->request->post('DATE') !== null) {
            $searchModel->DATE = Yii::$app->request->post('DATE');
        }
        $searchModel->PERIOD = date('Ym');
        if (\Yii::$app->request->post('PERIOD') !== null) {
            $searchModel->PERIOD = Yii::$app->request->post('PERIOD');
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
