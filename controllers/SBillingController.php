<?php

namespace app\controllers;

use app\models\search\SBillingSearch;
use app\models\search\SupplierBillingVoucherSearch;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\Response;
use dmstr\bootstrap\Tabs;
use app\models\Karyawan;
use app\models\SupplierBilling;
use app\models\SupplierBillingVoucher;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use app\models\SupplierBillingVoucherView;

/**
* This is the class for controller "SBillingController".
*/
class SBillingController extends \app\controllers\base\SBillingController
{
    public function actionFinishPayment()
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['s_billing_user'];
        $this->layout = 's-billing/main';
        date_default_timezone_set('Asia/Jakarta');

        $this_time = date('Y-m-d H:i:s');

        $response = [];
        if (\Yii::$app->request->isAjax) {
            $response = [
                'success' => true,
                'message' => 'Payment finish...',
            ];

            \Yii::$app->response->format = Response::FORMAT_JSON;
            $data_post = \Yii::$app->request->post();
            $tmp_str_val = $data_post['value'];
            $voucher_no_arr = explode('|', $tmp_str_val);
            $transfer_date = $data_post['transfer_date'];

            foreach ($voucher_no_arr as $voucher_no) {
                SupplierBillingVoucher::updateAll([
                    'payment_status' => 'C'
                ], ['voucher_no' => $voucher_no]);

                SupplierBilling::updateAll([
                    'stage' => 4,
                    'doc_finance_transfer_by' => $session['s_billing_name'],
                    'doc_finance_transfer_input_date' => $this_time,
                    'doc_finance_transfer_bank_date' => $transfer_date,
                    'doc_finance_transfer_stat' => 1,
                ], ['voucher_no' => $voucher_no]);
            }
            return $response;
        }
    }

	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('s_billing_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = 's-billing/login';

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
        $searchModel->dihapus = 'N';

        if(\Yii::$app->request->get('stage') !== null)
        {
            $searchModel->stage = \Yii::$app->request->get('stage');
        }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

        $supplier_dropdown = ArrayHelper::map(SupplierBilling::find()->select('supplier_name')->groupBy('supplier_name')->orderBy('supplier_name')->all(), 'supplier_name', 'supplier_name');

		return $this->render('data', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
            'supplier_dropdown' => $supplier_dropdown,
		]);
	}

    public function actionVoucher()
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        $this->layout = 's-billing/main';

        $searchModel  = new SupplierBillingVoucherSearch;
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('voucher', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionWaitingPayment()
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        $this->layout = 's-billing/main';

        $searchModel  = new SupplierBillingVoucherSearch;
        $searchModel->handover_status = 'C';
        $searchModel->payment_status = 'O';
        $dataProvider = $searchModel->search($_GET);

        $supplier_dropdown = ArrayHelper::map(SupplierBillingVoucherView::find()->select('supplier_name')->where([
            'handover_status' => 'C'
        ])->groupBy('supplier_name')->orderBy('supplier_name')->all(), 'supplier_name', 'supplier_name');

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('waiting-payment', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'supplier_dropdown' => $supplier_dropdown,
        ]);
    }

    public function actionVoucherRemoveInvoice($no, $voucher_no)
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        date_default_timezone_set('Asia/Jakarta');

        $model = $this->findModel($no);
        $model->voucher_no = null;

        if (!$model->save()) {
            return json_encode($model->errors);
        }

        $user_id = \Yii::$app->user->identity->username;

        SupplierBillingVoucher::updateAll(['update_by_id' => $session['s_billing_user'], 'update_by_name' => $session['s_billing_name'], 'update_datetime' => date('Y-m-d H:i:s')], ['voucher_no' => $voucher_no]);

        return $this->redirect(['voucher-detail', 'voucher_no' => $voucher_no]);
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

    public function actionReject($no)
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        date_default_timezone_set('Asia/Jakarta');

        $model = $this->findModel($no);
        /*$model->stage = 2;
        $model->doc_received_by = $session['s_billing_name'];
        $model->doc_received_date = date('Y-m-d H:i:s');
        $model->doc_received_stat = '1';

        if (!$model->save()) {
            return json_encode($model->errors);
        }*/

        \Yii::$app->getSession()->setFlash('success', 'Reject success...');

        return $this->redirect(Url::previous());
    }

	public function actionHandover($voucher_no)
	{
		$session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        date_default_timezone_set('Asia/Jakarta');

        /*$tmp_voucher = SupplierBillingVoucher::find()->where(['voucher_no' => $voucher_no])->one();
        $tmp_voucher->handover_status = 'C';*/

        SupplierBillingVoucher::updateAll(['handover_status' => 'C'], ['voucher_no' => $voucher_no]);

        /*if (!$tmp_voucher->save()) {
            return json_encode($tmp_voucher->errors);
        }*/

        //update invoice data
        SupplierBilling::updateAll([
            'stage' => 3,
            'open_close' => 'C',
            'doc_finance_handover_by' => $session['s_billing_name'],
            'doc_finance_handover_date' => date('Y-m-d H:i:s'),
            'doc_finance_handover_stat' => '1',
        ], ['voucher_no' => $voucher_no]);

        \Yii::$app->getSession()->setFlash('success', 'Handover success...');

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

    public function actionVoucherAttachment($voucher_no)
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }

        $sql = "{CALL SUPPLIER_BILLING_VEFIFIKASI_DOC_DOWNLOAD(:voucher_no)}";
        // passing the params into to the sql query
        $params = [':voucher_no'=>$voucher_no];
        $result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryOne();
        $b64 = $result['docbase64'];

        $bin = base64_decode($b64, true);
        if (strpos($bin, '%PDF') !== 0) {
          throw new Exception('Missing the PDF file signature');
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . $voucher_no . '.pdf');
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

    public function actionVoucherDetail($voucher_no)
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');

        $this->layout = 's-billing/main';

        $invoice_data = SupplierBilling::find()->where([
            'voucher_no' => $voucher_no,
            'dihapus' => 'N'
        ])->all();
        $voucher_data = SupplierBillingVoucher::find()->where(['voucher_no' => $voucher_no])->one();

        return $this->render('voucher-detail', [
            'invoice_data' => $invoice_data,
            'voucher_no' => $voucher_no,
            'voucher_data' => $voucher_data,
        ]);
    }

    public function actionVoucherAttachmentEdit($voucher_no)
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }

        $this->layout = 's-billing/main';

        $model = SupplierBillingVoucher::find()->where([
            'voucher_no' => $voucher_no
        ])->one();

        if ($model->load(\Yii::$app->request->post())) {

            $model->attachment_file = $tmp_attachment = UploadedFile::getInstance($model, 'attachment_file');
            //$tmp_attachment = UploadedFile::getInstance($model, 'attachment_file');
            if ($model->attachment_file) {
                $tmp_data = file_get_contents($tmp_attachment->tempName);
                $base64 = base64_encode($tmp_data);
                //return $base64;
            } else {
                \Yii::$app->session->setFlash('danger', "Attachment is empty");
                return $this->render('voucher-attachment-edit', [
                    'model' => $model,
                ]);
            }
            
            $sql = "{CALL SUPPLIER_BILLING_VEFIFIKASI_REVISI(:voucher_no, :update_by_id, :update_by_name, :dokumen)}";
            $params = [
                ':voucher_no' => $model->voucher_no,
                ':update_by_id' =>  $session['s_billing_user'],
                ':update_by_name' => $session['s_billing_name'],
                ':dokumen' => $base64,
            ];

            try {
                $result = \Yii::$app->db_wsus->createCommand($sql, $params)->execute();
                \Yii::$app->session->setFlash('success', "Attachment for Voucher no. " . $model->voucher_no . " updated successfully...");
            } catch (Exception $ex) {
                \Yii::$app->session->setFlash('danger', "Error : $ex");
                return $this->render('voucher-attachment-edit', [
                    'model' => $model,
                ]);
            }

            return $this->redirect(Url::previous());
        }

        return $this->render('voucher-attachment-edit', [
            'model' => $model,
        ]);
    }

    public function actionCreateVoucher()
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');

        $this->layout = 's-billing/main';

        $model = new SupplierBillingVoucher;
        $base64 = '';
        if ($model->load(\Yii::$app->request->post())) {

            $model->create_by_id = $session['s_billing_user'];
            $model->create_by_name = $session['s_billing_name'];
            $model->create_time = $this_time;
            $model->attached_by_id = $session['s_billing_user'];
            $model->attached_by_name = $session['s_billing_name'];
            $model->attached_time = $this_time;

            $model->attachment_file = $tmp_attachment = UploadedFile::getInstance($model, 'attachment_file');
            //$tmp_attachment = UploadedFile::getInstance($model, 'attachment_file');
            if ($model->attachment_file) {
                $tmp_data = file_get_contents($tmp_attachment->tempName);
                $base64 = base64_encode($tmp_data);

                $sql = "{CALL SUPPLIER_BILLING_VEFIFIKASI_REG(:voucher_no, :create_by_id, :create_by_name, :dokumen)}";
                $params = [
                    ':voucher_no' => $model->voucher_no,
                    ':create_by_id' =>  $model->create_by_id,
                    ':create_by_name' => $model->create_by_name,
                    ':dokumen' => $base64,
                ];

                try {
                    $result = \Yii::$app->db_wsus->createCommand($sql, $params)->execute();
                    \Yii::$app->session->setFlash('success', "Voucher no. " . $model->voucher_no . " created successfully...");
                } catch (Exception $ex) {
                    \Yii::$app->session->setFlash('danger', "Error : $ex");
                    return $this->render('create-voucher', [
                        'model' => $model,
                    ]);
                }
            } else {
                if (!$model->save()) {
                    return json_encode($model->errors);
                }
            }
            
            $no_arr = $model->invoice_no;
            foreach ($no_arr as $no_val) {
                SupplierBilling::updateAll(['voucher_no' => $model->voucher_no], ['no' => $no_val]);
            }

            return $this->redirect(Url::previous());

        }

        $tmp_supplier_dropdown = ArrayHelper::map(SupplierBilling::find()->select(['supplier_name'])->where([
            'stage' => 2,
            'open_close' => 'O',
            'dihapus' => 'N'
        ])->groupBy('supplier_name')->orderBy('supplier_name')->all(), 'supplier_name', 'supplier_name');

        return $this->render('create-voucher', [
            'model' => $model,
            'tmp_supplier_dropdown' => $tmp_supplier_dropdown,
        ]);
    }
        
    public function actionGetInvoiceBySupplier($supplier_name)
    {
        if ($supplier_name != null) {
            $tmp_data = SupplierBilling::find()->where([
                'supplier_name' => $supplier_name,
                'stage' => 2,
                'open_close' => 'O',
                'dihapus' => 'N'
            ])->all();

            if (count($tmp_data) > 0) {
                foreach ($tmp_data as $key => $value) {
                    echo "<option value='" . $value->no . "'>" . $value->invoice_no . "</option>";
                }
            } else {
                echo "'<option>-</option>'";
            }
            
        }
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

    public function actionVoucherAddInvoice($voucher_no)
    {
        $session = \Yii::$app->session;
        if (!$session->has('s_billing_user')) {
            return $this->redirect(['login']);
        }

        $model = new \yii\base\DynamicModel([
            'invoice_no', 'supplier_name'
        ]);
        $model->addRule(['invoice_no', 'supplier_name'], 'required');

        date_default_timezone_set('Asia/Jakarta');

        if ($model->load(\Yii::$app->request->post())) {
            $no_arr = $model->invoice_no;
            foreach ($no_arr as $no_val) {
                SupplierBilling::updateAll(['voucher_no' => $voucher_no], ['no' => $no_val]);
            }

            return $this->redirect(['voucher-detail', 'voucher_no' => $voucher_no]);
        }

        $tmp_supplier_dropdown = ArrayHelper::map(SupplierBilling::find()->select(['supplier_name'])->where([
            'stage' => 2,
            'open_close' => 'O'
        ])->andWhere('voucher_no IS NULL')->groupBy('supplier_name')->orderBy('supplier_name')->all(), 'supplier_name', 'supplier_name');

        return $this->renderAjax('voucher-add-invoice', [
            'model' => $model,
            'tmp_supplier_dropdown' => $tmp_supplier_dropdown,
        ]);
    }
}
