<?php
namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use yii\web\Controller;
use app\models\Karyawan;
use app\models\WipEffTbl;
use app\models\search\ExternalDandoriDataSearch;

class ExternalDandoriController extends Controller
{
	public function actionIndex($value='')
	{
		$session = \Yii::$app->session;
        if (!$session->has('external_dandori_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['external_dandori_user'];

        $this->layout = "external-dandori\main";

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;


		return $this->render('index', [
            'total_request' => $total_request,
            'total_progress' => $total_progress,
            'nik' => $nik
        ]);
	}

	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('external_dandori_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = "external-dandori\login";

        $model = new \yii\base\DynamicModel([
            'username', 'password'
        ]);
        $model->addRule(['username', 'password'], 'required');

        if($model->load(\Yii::$app->request->post())){
            $karyawan = Karyawan::find()
            ->where([
                'NIK' => $model->username,
                //'PASSWORD' => $model->password,
            ])
            ->orWhere([
                'NIK_SUN_FISH' => $model->username,
                //'PASSWORD' => $model->password,
            ])
            ->one();
            if ($karyawan->NIK_SUN_FISH == null) {
                \Yii::$app->getSession()->setFlash('warning', 'New NIK format is not set. Please request to HR.');
            } else {
                if ($model->password == $karyawan->PASSWORD) {
                    $session['external_dandori_user'] = $karyawan->NIK_SUN_FISH;
                    $session['external_dandori_name'] = $karyawan->NAMA_KARYAWAN;
                    return $this->redirect(['index']);
                } else {
                    \Yii::$app->getSession()->setFlash('error', 'Incorrect username or password...');
                }
            }
            
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        $session = \Yii::$app->session;
        if ($session->has('external_dandori_user')) {
            $session->remove('external_dandori_user');
            $session->remove('external_dandori_name');
        }

        return $this->redirect(['login']);
    }

    public function actionData()
    {
        $session = \Yii::$app->session;
        if (!$session->has('external_dandori_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['external_dandori_user'];
        $this->layout = 'external-dandori\main';

        $searchModel  = new ExternalDandoriDataSearch;

	    /*$searchModel->plan_date = date('Y-m-d');
	    if(\Yii::$app->request->get('plan_date') !== null)
	    {
	    	$searchModel->plan_date = \Yii::$app->request->get('plan_date');
	    }*/
	    $searchModel->plan_stats = 'O';
	    $searchModel->plan_run = 'N';
	    $searchModel->child_analyst = 'WM03';

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('data', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
    }

    public function actionDandoriStart($lot_id)
    {
        $session = \Yii::$app->session;
        if (!$session->has('external_dandori_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['external_dandori_user'];
        $name = $session['external_dandori_name'];
        $this->layout = 'external-dandori\main';
        date_default_timezone_set('Asia/Jakarta');

        $input_model = new \yii\base\DynamicModel([
            'carriage_qty'
        ]);
        $input_model->addRule(['carriage_qty'], 'required');

        if ($input_model->load(\Yii::$app->request->post())) {
            //return $job_hdr_no . ', ' . $input_model->confirm_schedule_date . ' - ' . $nik;
            $model = WipEffTbl::find()
            ->where([
            	'lot_id' => $lot_id
            ])
            ->one();

            $this_time = date('Y-m-d H:i:s');
            $model->ext_dandori_status = 1;
            $model->ext_dandori_start = $this_time;
            $model->ext_dandori_nik = $nik;
            $model->ext_dandori_name = $name;
            $model->ext_dandori_last_update = $this_time;
            $model->carriage_total = $model->carriage_open = $input_model->carriage_qty;
            $model->carriage_finish = 0;

            if (!$model->save()) {
            	return json_encode($model->errors);
            }
            return $this->redirect(Url::previous());
        }

        return $this->renderAjax('dandori-start', [
            'input_model' => $input_model
        ]);
    }

    public function actionDandoriEnd($lot_id)
    {
    	$session = \Yii::$app->session;
        if (!$session->has('external_dandori_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['external_dandori_user'];
        $name = $session['external_dandori_name'];

    	date_default_timezone_set('Asia/Jakarta');
    	$model = WipEffTbl::find()
    	->where([
    		'lot_id' => $lot_id
    	])
    	->one();

    	$this_time = date('Y-m-d H:i:s');
    	$model->ext_dandori_end = $this_time;
    	$model->ext_dandori_status = 2;
    	$model->ext_dandori_end_nik = $nik;
    	$model->ext_dandori_end_name = $name;
    	$model->ext_dandori_last_update = $this_time;

    	if (!$model->save()) {
    		return $model->errors;
    	}
    	return $this->redirect(Url::previous());
    }

    public function actionDandoriHandover($lot_id)
    {
    	$session = \Yii::$app->session;
        if (!$session->has('external_dandori_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['external_dandori_user'];
        $name = $session['external_dandori_name'];

    	date_default_timezone_set('Asia/Jakarta');
    	$model = WipEffTbl::find()
    	->where([
    		'lot_id' => $lot_id
    	])
    	->one();

    	$this_time = date('Y-m-d H:i:s');
    	$model->ext_dandori_handover = $this_time;
    	$model->ext_dandori_status = 3;
    	$model->ext_dandori_handover_nik = $nik;
    	$model->ext_dandori_handover_name = $name;
    	$model->ext_dandori_last_update = $this_time;
    	$model->ext_dandori_lt = strtotime($this_time) - strtotime($model->ext_dandori_start);

    	if (!$model->save()) {
    		return json_encode($model->errors);
    	}

    	return $this->redirect(Url::previous());
    }

}