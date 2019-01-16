<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\RekapAbsensiView;
use app\models\search\CutiTblSearch;
use app\models\SplView;
use app\models\CutiTbl;


class CutiTblController extends \app\controllers\MyHrController
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new CutiTblSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionView($CUTI_ID)
	{
		\Yii::$app->session['__crudReturnUrl'] = Url::previous();
		Url::remember();
		Tabs::rememberActiveState();

		$model = $this->findModel($CUTI_ID);
		$model_rekap_absensi = RekapAbsensiView::find()->where([
            'NIK' => $model->NIK,
            'YEAR' => $model->TAHUN
        ])
        ->orderBy('PERIOD')
        ->all();

		return $this->render('view', [
			'model_rekap_absensi' => $model_rekap_absensi,
			'nik' => $model->NIK,
			'nama_karyawan' => $model->NAMA_KARYAWAN,
			'tahun' => $model->TAHUN,
		]);
	}

	public function actionUpdate($CUTI_ID)
	{
		$model = $this->findModel($CUTI_ID);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	protected function findModel($CUTI_ID)
	{
		if (($model = CutiTbl::findOne($CUTI_ID)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
