<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\Karyawan;
use app\models\search\IqaInspectionSearch;

class RdrDprController extends \app\controllers\base\IqaInspectionController
{
	public function actionReport($SEQ_LOG)
	{
		$session = \Yii::$app->session;
        if (!$session->has('rdr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['rdr_user'];
        $name = $session['rdr_name'];
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($SEQ_LOG);
		//$model->POST_DATE = date('Y-m-d', strtotime($model->POST_DATE));

		$model_judgement = new \yii\base\DynamicModel([
	        'judgement', 'remark'
	    ]);
	    $model_judgement->addRule(['judgement'], 'required')
	    ->addRule(['remark'], 'string');

	    if ($model->Judgement != null) {
			$model_judgement->judgement = $model->Judgement;
		}

		if ($model->Remark != null) {
			$model_judgement->remark = $model->Remark;
		}

		if ($model_judgement->load(\Yii::$app->request->post())) {
			$model->Judgement = $model_judgement->judgement;
			if ($model_judgement->remark != '') {
				$model->Remark = $model_judgement->remark;
			}
			$model->inspect_by_id = $nik;
			$model->inspect_by_name = $name;
			$model->inspect_datetime = date('Y-m-d H:i:s');
			$model->inspect_period = date('Ym');

			if (!$model->save()) {
				return json_encode($model->errors);
			}

			return $this->redirect(Url::previous());
		} else {
			return $this->renderAjax('report', [
				'model' => $model,
				'model_judgement' => $model_judgement,
			]);
		}
	}

	public function actionData()
	{
		$session = \Yii::$app->session;
        if (!$session->has('rdr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['rdr_user'];
		$this->layout = 'rdr-dpr\main';
	    $searchModel  = new IqaInspectionSearch;
	    $searchModel->TRANS_ID = '11';
	    $searchModel->LAST_UPDATE = date('Y-m-d');

	    if(\Yii::$app->request->get('LAST_UPDATE') !== null)
	    {
	    	$searchModel->LAST_UPDATE = \Yii::$app->request->get('LAST_UPDATE');
	    }/**/
        if(\Yii::$app->request->get('Judgement') !== null)
        {
            $searchModel->Judgement = \Yii::$app->request->get('Judgement');
        }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('data', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('rdr_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = "rdr-dpr\login";

        $model = new \yii\base\DynamicModel([
            'username', 'password'
        ]);
        $model->addRule(['username', 'password'], 'required');

        if($model->load(\Yii::$app->request->post())){
            $karyawan = Karyawan::find()
            ->where([
            	'OR',
                ['NIK' => $model->username],
                ['NIK_SUN_FISH' => $model->username],
            ])
            ->andWhere(['PASSWORD' => $model->password,])
            ->one();
            if ($karyawan->NIK !== null) {
                $session['rdr_user'] = $karyawan->NIK_SUN_FISH;
                $session['rdr_nik'] = $karyawan->NIK;
                $session['rdr_name'] = $karyawan->NAMA_KARYAWAN;
                $session['rdr_cc_id'] = $karyawan->CC_ID;
                $session['rdr_department'] = $karyawan->DEPARTEMEN;
                return $this->redirect(['index']);
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Incorrect username or password...');
            }
            $model->username = null;
            $model->password = null;
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        $session = \Yii::$app->session;
        if ($session->has('rdr_user')) {
            $session->remove('rdr_user');
            $session->remove('rdr_name');
            $session->remove('rdr_cc_id');
            $session->remove('rdr_department');
        }

        return $this->redirect(['login']);
    }

	public function actionIndex()
	{
		$session = \Yii::$app->session;
        if (!$session->has('rdr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['rdr_user'];
		$this->layout = 'rdr-dpr/main';
		return $this->render('index');
	}

}