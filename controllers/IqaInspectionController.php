<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\SapPoRcvSearch;
use app\models\Karyawan;

/**
* This is the class for controller "SapPoRcvController".
*/
class IqaInspectionController extends \app\controllers\base\SapPoRcvController
{
	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('iqa_inspection_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = "iqa-inspection\login";

        $model = new \yii\base\DynamicModel([
            'username', 'password'
        ]);
        $model->addRule(['username', 'password'], 'required');

        if($model->load(\Yii::$app->request->post())){
            $karyawan = Karyawan::find()
            ->where([
                'NIK' => $model->username,
                'PASSWORD' => $model->password,
            ])
            ->one();
            if ($karyawan->NIK !== null) {
                $session['iqa_inspection_user'] = $model->username;
                $session['iqa_inspection_name'] = $karyawan->NAMA_KARYAWAN;
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
        if ($session->has('iqa_inspection_user')) {
            $session->remove('iqa_inspection_user');
            $session->remove('iqa_inspection_name');
        }

        return $this->redirect(['login']);
    }
	public function actionIndex($value='')
	{
		$session = \Yii::$app->session;
        if (!$session->has('iqa_inspection_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['iqa_inspection_user'];

        $model_karyawan = Karyawan::find()->where([
            'NIK' => $nik
        ])->one();

		$this->layout = 'iqa-inspection\main';
		return $this->render('index');
	}
	public function actionData()
	{
		$session = \Yii::$app->session;
        if (!$session->has('iqa_inspection_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['iqa_inspection_user'];
		$this->layout = 'iqa-inspection\main';
	    $searchModel  = new SapPoRcvSearch;
	    /*$searchModel->rcv_date = date('Y-m-d');

	    if(\Yii::$app->request->get('rcv_date') !== null)
	    {
	    	$searchModel->rcv_date = \Yii::$app->request->get('rcv_date');
	    }*/

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('data', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionJudgement($material_document_number)
	{
		$session = \Yii::$app->session;
        if (!$session->has('iqa_inspection_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['iqa_inspection_user'];
        $name = $session['iqa_inspection_name'];
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($material_document_number);
		$model->rcv_date = date('Y-m-d', strtotime($model->rcv_date));

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
			return $this->renderAjax('judgement', [
				'model' => $model,
				'model_judgement' => $model_judgement,
			]);
		}
	}
}
