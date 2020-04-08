<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\Karyawan;
use app\models\search\IqaInspectionSearch;
use app\models\search\RdrDprDataSearch;
use app\models\RdrDprData;

class RdrDprController extends \app\controllers\base\IqaInspectionController
{
    public function actionKorlapApprove($material_document_number)
    {
        $session = \Yii::$app->session;
        if (!$session->has('rdr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['rdr_user'];
        $name = $session['rdr_name'];
        date_default_timezone_set('Asia/Jakarta');

        $tmp_model = RdrDprData::find()->where(['material_document_number' => $material_document_number])->one();
        $tmp_model->korlap = $nik;
        $tmp_model->korlap_desc = $name;
        $tmp_model->korlap_confirm_date = date('Y-m-d H:i:s');

        if ($tmp_model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return json_encode($model->errors);
        }
    }

    public function actionKorlapApprovalData($value='')
    {
        $session = \Yii::$app->session;
        if (!$session->has('rdr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['rdr_user'];
        $this->layout = 'rdr-dpr\main';

        $searchModel  = new RdrDprDataSearch;
        $_GET['approval_type'] = 'korlap';
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('korlap-approval-data', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

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
	        'type', 'category', 'urgency', 'actual_qty'
	    ]);
	    $model_judgement->addRule(['type', 'category', 'urgency', 'actual_qty'], 'required');
        $model_judgement->actual_qty = $model->QTY_IN;

		if ($model_judgement->load(\Yii::$app->request->post())) {
			$params = [
                ':material_document_number' => $SEQ_LOG,
                ':rdr_dpr' => $model_judgement->type,
                ':category' => $model_judgement->category,
                ':normal_urgent' => $model_judgement->urgency,
                ':act_rcv_qty' => $model_judgement->actual_qty,
                ':user_id' => $nik,
                ':user_desc' => $name,
            ];

            $sql = "{CALL RDR_DPR_CREATE(:material_document_number, :rdr_dpr, :category, :normal_urgent, :act_rcv_qty, :user_id, :user_desc)}";

			try {
                $result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryOne();
                $hasil = $result['HASIL'];
                if ($hasil == 'SUKSES') {
                    \Yii::$app->session->setFlash('success', 'RDR/DPR form created successfully...');
                } elseif ($hasil == 'NOMER SLIP SUDAH TERDAFTAR') {
                    \Yii::$app->session->setFlash('warning', 'This slip number already registered...!');
                }
            } catch (Exception $ex) {
                return json_encode($ex);
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