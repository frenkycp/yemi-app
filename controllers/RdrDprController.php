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
    public function actionClose($material_document_number)
    {
        $session = \Yii::$app->session;
        if (!$session->has('rdr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['rdr_user'];
        $name = $session['rdr_name'];
        date_default_timezone_set('Asia/Jakarta');

        $tmp_model = RdrDprData::find()->where(['material_document_number' => $material_document_number])->one();
        $tmp_model->status_val = 3;
        $tmp_model->user_close = $nik;
        $tmp_model->user_close_desc = $name;
        $tmp_model->user_close_date = date('Y-m-d H:i:s');
        $tmp_model->close_open = 'C';

        if ($tmp_model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return json_encode($model->errors);
        }
    }

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
        $tmp_model->status_val = 1;
        $tmp_model->korlap_desc = $name;
        $tmp_model->korlap_confirm_date = date('Y-m-d H:i:s');

        $content = 'Dear Mr./Mrs. ' . ucwords(strtolower($tmp_model->pic)) . ',<br/>Laporan berikut sudah di Approve oleh koordinator lapangan. Tolong di follow up.<br/>';

        $content .= '<br/>Doc. Number : ' . $tmp_model->material_document_number;
        $content .= '<br/>Rcv. Date : ' . date('Y-m-d', strtotime($tmp_model->rcv_date));
        $content .= '<br/>RDR / DPR : ' . $tmp_model->rdr_dpr;
        $content .= '<br/>Material : ' . $tmp_model->material;
        $content .= '<br/>Description : ' . $tmp_model->description;
        $content .= '<br/>Vendor Code : ' . $tmp_model->vendor_code;
        $content .= '<br/>Vendor Name : ' . $tmp_model->vendor_name;
        $content .= '<br/>DO Inv. Qty : ' . $tmp_model->do_inv_qty;
        $content .= '<br/>Actual Qty : ' . $tmp_model->act_rcv_qty;
        $content .= '<br/>Discrepancy Qty : ' . $tmp_model->discrepancy_qty;
        $content .= '<br/>Category : ' . $tmp_model->category;
        $content .= '<br/>Priority : ' . $tmp_model->normal_urgent;
        $content .= '<br/>Issued Date : ' . date('d F Y H:i:s', strtotime($tmp_model->user_issue_date));
        $content .= '<br/>Issued By : ' . $tmp_model->user_id . ' - ' . $tmp_model->user_desc;
        $content .= '<br/><br/>Thanks & Best Regards';
        $content .= '<br/>' . $tmp_model->korlap . ' - ' . $tmp_model->korlap_desc;

        if ($tmp_model->save()) {
            if ($tmp_model->EMAIL_ADDRESS != null && $tmp_model->EMAIL_ADDRESS != '') {
                $set_to = $tmp_model->EMAIL_ADDRESS;
                $set_cc = [$tmp_model->EMAIL_ADDRESS_CC];

                $set_to = 'frenky.purnama@music.yamaha.com';
                $set_cc = ['fredy.agus@music.yamaha.com'];

                \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/html'], [
                    'content' => $content
                ])
                ->setFrom('yemi.pch@gmail.com')
                ->setTo($set_to)
                ->setCc($set_cc)
                ->setSubject('RDR - DPR Report')
                ->send();

                \Yii::$app->session->setFlash("success", "Email has been sent to the correspondence PIC.");
            } else {
                \Yii::$app->session->setFlash("warning", "There is no email for the correspondence PIC. Please contact personally.");
            }
            
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
        //$_GET['approval_type'] = 'korlap';
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('korlap-approval-data', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPchApprovalData($value='')
    {
        $session = \Yii::$app->session;
        if (!$session->has('rdr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['rdr_user'];
        $this->layout = 'rdr-dpr\main';

        $searchModel  = new RdrDprDataSearch;
        $_GET['approval_type'] = 'pch';
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('pch-approval-data', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPchApprove($material_document_number)
    {
        $session = \Yii::$app->session;
        if (!$session->has('rdr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['rdr_user'];
        $name = $session['rdr_name'];
        date_default_timezone_set('Asia/Jakarta');
        $model = RdrDprData::find()->where(['material_document_number' => $material_document_number])->one();

        if ($model->load(\Yii::$app->request->post())) {
            try {
                $model->status_val = 2;
                $model->purc_approve = $nik;
                $model->purc_approve_desc = $name;
                $model->purc_approve_date = date('Y-m-d H:i:s');
                if ($model->save()) {
                    \Yii::$app->session->setFlash('success', 'Document No. ' . $material_document_number . ' approved by Purchasing');
                } else {
                    return json_encode($model->errors);
                }
            } catch (Exception $ex) {
                return json_encode($ex);
            }
            
            return $this->redirect(Url::previous());
        } else {
            return $this->renderAjax('pch-approve', [
                'model' => $model,
            ]);
        }
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