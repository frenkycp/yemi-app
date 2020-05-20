<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\IqaInspectionSearch;
use app\models\Karyawan;
use app\models\StoreInOutWsus;

/**
* This is the class for controller "SapPoRcvController".
*/
class IqaInspectionController extends \app\controllers\base\IqaInspectionController
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

	public function actionJudgement($SEQ_LOG)
	{
		$session = \Yii::$app->session;
        if (!$session->has('iqa_inspection_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['iqa_inspection_user'];
        $name = $session['iqa_inspection_name'];
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
			return $this->renderAjax('judgement', [
				'model' => $model,
				'model_judgement' => $model_judgement,
			]);
		}
	}

    public function actionJudgeWi($value='')
    {
        $session = \Yii::$app->session;
        if (!$session->has('iqa_inspection_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['iqa_inspection_user'];
        $name = $session['iqa_inspection_name'];
        $this->layout = 'iqa-inspection\main';
        date_default_timezone_set('Asia/Jakarta');

        $condition = ['IQA' => 'W/I'];

        $rows = StoreInOutWsus::updateAll([
            'Judgement' => 'OK',
            'inspect_datetime' => date('Y-m-d H:i:s'),
            'inspect_period' => date('Ym'),
        ], $condition);

        return $this->redirect(Url::previous());
    }

	public function actionDailyInspection()
	{
		$session = \Yii::$app->session;
        if (!$session->has('iqa_inspection_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['iqa_inspection_user'];
        $name = $session['iqa_inspection_name'];
        $this->layout = 'iqa-inspection\main';
        date_default_timezone_set('Asia/Jakarta');

        $data = $tmp_data_open = $tmp_data_ok = $tmp_data_ng = [];

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        if (date('d') < 26) {
            $model->from_date = date('Y-m-d', strtotime(date('Y-m-26') . '-1 month'));
            $model->to_date = date('Y-m-d', strtotime(date('Y-m-25')));
        } else {
            $model->from_date = date('Y-m-d', strtotime(date('Y-m-26')));
            $model->to_date = date('Y-m-d', strtotime(date('Y-m-25') . '+1 month'));
        }
        

        if ($model->load($_GET)) {}

    	$in_out_data = StoreInOutWsus::find()
    	->select([
    		'LAST_UPDATE' => 'FORMAT(LAST_UPDATE, \'yyyy-MM-dd\')',
    		'TOTAL_ITEM' => 'COUNT(SEQ_LOG)',
    		'TOTAL_OK' => 'SUM(CASE WHEN Judgement = \'OK\' THEN 1 ELSE 0 END)',
    		'TOTAL_NG' => 'SUM(CASE WHEN Judgement = \'NG\' THEN 1 ELSE 0 END)',
    		'TOTAL_OPEN' => 'SUM(CASE WHEN Judgement IS NULL THEN 1 ELSE 0 END)'
    	])
    	->where([
    		'AND',
    		['>=', 'LAST_UPDATE', $model->from_date . ' 00:00:00'],
    		['<=', 'LAST_UPDATE', $model->to_date . ' 23:59:59'],
    	])
    	->andWhere(['TRANS_ID' => 11])
    	->groupBy(['FORMAT(LAST_UPDATE, \'yyyy-MM-dd\')'])
    	->orderBy('LAST_UPDATE')
    	->all();

        $tmp_total_ok = $tmp_total_ng = 0;
        $tgl_arr = [];
    	foreach ($in_out_data as $key => $value) {
    		$post_date = (strtotime($value->LAST_UPDATE . " +7 hours") * 1000);
            $tgl_arr[] = $value->LAST_UPDATE;
            $tmp_total_ok += (int)$value->TOTAL_OK;
            $tmp_total_ng += (int)$value->TOTAL_NG;
			$tmp_data_open[] = [
				'x' => $post_date,
				'y' => $value->TOTAL_OPEN == 0 ? null : (int)$value->TOTAL_OPEN,
				'url' => Url::to(['data', 'LAST_UPDATE' => date('Y-m-d', strtotime($value->LAST_UPDATE)), 'Judgement' => 'PENDING']),
			];
			$tmp_data_ok[] = [
				'x' => $post_date,
				'y' => $value->TOTAL_OK == 0 ? null : (int)$value->TOTAL_OK,
				'url' => Url::to(['data', 'LAST_UPDATE' => date('Y-m-d', strtotime($value->LAST_UPDATE)), 'Judgement' => 'OK']),
			];
			$tmp_data_ng[] = [
				'x' => $post_date,
				'y' => $value->TOTAL_NG == 0 ? null : (int)$value->TOTAL_NG,
				'url' => Url::to(['data', 'LAST_UPDATE' => date('Y-m-d', strtotime($value->LAST_UPDATE)), 'Judgement' => 'NG']),
			];
    	}

        $ng_rate = 0;
        if ($tmp_total_ok > 0) {
            $ng_rate = round(($tmp_total_ng / $tmp_total_ok) * 100, 2);
        }

    	$data = [
    		[
    			'name' => 'UNDER INSPECTION',
    			'data' => $tmp_data_open,
    			'color' => \Yii::$app->params['bg-light-blue']
    		],
    		[
    			'name' => 'OK',
    			'data' => $tmp_data_ok,
    			'color' => \Yii::$app->params['bg-green']
    		],
    		[
    			'name' => 'NG',
    			'data' => $tmp_data_ng,
    			'color' => \Yii::$app->params['bg-red']
    		],
    	];

        $ng_data_arr = StoreInOutWsus::find()
        ->where([
            'AND',
            ['>=', 'LAST_UPDATE', $model->from_date],
            ['<=', 'LAST_UPDATE', $model->to_date],
        ])
        ->andWhere([
            'TRANS_ID' => 11,
            'Judgement' => 'NG'
        ])
        ->asArray()
        ->all();

        $target_ng_rate = 0.11;

        return $this->render('daily-inspection', [
        	'data' => $data,
            'tgl_arr' => $tgl_arr,
        	'model' => $model,
            'ng_data_arr' => $ng_data_arr,
            'tmp_total_ng' => $tmp_total_ng,
            'tmp_total_ok' => $tmp_total_ok,
            'ng_rate' => $ng_rate,
            'target_ng_rate' => $target_ng_rate,
        ]);
	}
}
