<?php

namespace app\controllers;

use app\models\search\SBillingSearch;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\Karyawan;
use app\models\SupplierBilling;

/**
* This is the class for controller "SBillingController".
*/
class SBillingController extends \app\controllers\base\SBillingController
{
	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('s_billing_user')) {
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
            	'OR',
                ['NIK' => $model->username],
                ['NIK_SUN_FISH' => $model->username],
            ])
            ->andWhere(['PASSWORD' => $model->password,])
            ->one();
            if ($karyawan->NIK !== null) {
                $session['s_billing_user'] = $karyawan->NIK_SUN_FISH;
                $session['s_billing_nik'] = $karyawan->NIK;
                $session['s_billing_name'] = $karyawan->NAMA_KARYAWAN;
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

    public function actionIndex($value='')
    {
    	$session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['s_billing_user'];
		$this->layout = 's-billing/main';

		$tmp_total = SupplierBilling::find()
		->select([
			'total_stage1' => 'SUM(CASE WHEN stage = 1 THEN 1 ELSE 0 END)',
			'total_stage2' => 'SUM(CASE WHEN stage = 2 THEN 1 ELSE 0 END)',
			'total_stage3' => 'SUM(CASE WHEN stage = 3 THEN 1 ELSE 0 END)',
		])
		->one();

		return $this->render('index', [
			'tmp_total' => $tmp_total
		]);
    }

    public function actionLogout()
    {
        $session = \Yii::$app->session;
        if ($session->has('s_billing_user')) {
            $session->remove('s_billing_user');
            $session->remove('s_billing_name');
        }

        return $this->redirect(['login']);
    }

    public function actionData()
	{
		$session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
		$this->layout = 's-billing/main';

	    $searchModel  = new SBillingSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('data', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionReceive($no)
	{
		$session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        date_default_timezone_set('Asia/Jakarta');

        $model = $this->findModel($no);
        $model->stage = 2;
        $model->doc_received_by = $session['s_billing_name'];
        $model->doc_received_date = date('Y-m-d H:i:s');
        $model->doc_received_stat = '1';

        if (!$model->save()) {
        	return json_encode($model->errors);
        }

        return $this->redirect(Url::previous());
	}

	public function actionHandover($no)
	{
		$session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        date_default_timezone_set('Asia/Jakarta');

        $model = $this->findModel($no);
        $model->stage = 4;
        $model->open_close = 'C';
        $model->doc_finance_handover_by = $session['s_billing_name'];
        $model->doc_finance_handover_date = date('Y-m-d H:i:s');
        $model->doc_finance_handover_stat = '1';

        if (!$model->save()) {
        	return json_encode($model->errors);
        }

        return $this->redirect(Url::previous());
	}

	public function actionVendorAttachment($no)
	{
		$session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }

        $sql = "{CALL SUPPLIER_BILLING_DOC_DOWNLOAD(:no)}";
		// passing the params into to the sql query
		$params = [':no'=>$no];
		$result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryOne();
		$b64 = $result['docbase64'];

        $bin = base64_decode($b64, true);
		if (strpos($bin, '%PDF') !== 0) {
		  throw new Exception('Missing the PDF file signature');
		}
		header('Content-Description: File Transfer');
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename=' . $no . '.pdf');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . strlen($bin));
		ob_clean();
		flush();
		echo $bin;
		exit;
	}

	public function actionRemark($no)
	{
		$session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }

		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($no);

		if ($model->load(\Yii::$app->request->post())) {
			if ($model->save()) {
				return $this->redirect(Url::previous());
			} else {
				return json_encode($model->errors);
			}

			//return $this->redirect(Url::previous());
		}

		return $this->renderAjax('remark', [
    		'model' => $model
    	]);
	}

	public function actionPchFinish($no)
	{
		$session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }

        $model = new \yii\base\DynamicModel([
        	'attachment'
	    ]);
	    $model->addRule(['attachment'], 'file');

		date_default_timezone_set('Asia/Jakarta');
		

		if ($model->load(\Yii::$app->request->post())) {
			$model_update = $this->findModel($no);
			$model_update->stage = 3;
			$model_update->doc_pch_finished_by = $session['s_billing_name'];
	        $model_update->doc_pch_finished_date = date('Y-m-d H:i:s');
	        $model_update->doc_pch_finished_stat = '1';
			if ($model_update->save()) {
				return $this->redirect(Url::previous());
			} else {
				return json_encode($model_update->errors);
			}

			//return $this->redirect(Url::previous());
		}

		return $this->renderAjax('pch-finish', [
    		'model' => $model
    	]);
	}
}
