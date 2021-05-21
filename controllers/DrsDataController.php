<?php
namespace app\controllers;

use yii\web\Controller;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\search\DrsDataSearch;
use app\models\DrsTbl;
use app\models\Karyawan;

class DrsDataController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
        $searchModel  = new DrsDataSearch;

        $searchModel->DRS_DATE = date('Y-m-d');
		if (\Yii::$app->request->post('DRS_DATE') != null) {
			$searchModel->DRS_DATE = \Yii::$app->request->post('DRS_DATE');
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

    public function actionRequest($DRS_NO)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$model = $this->findModel($DRS_NO);

    	$user_info = $this->getUser(\Yii::$app->user->identity->username, \Yii::$app->user->identity->name);

    	$model->SUPPLEMENT_REQUEST = 'Y';
    	$model->REQUEST_STAGE = 1;
    	$model->PROD_REQUEST_ID = $user_info['id'];
    	$model->PROD_REQUEST_NAME = $user_info['name'];
    	$model->PROD_REQUEST_DATETIME = date('Y-m-d H:i:s');

    	if (!$model->save()) {
    		return json_encode($model->errors);
    	}

    	return $this->redirect(Url::previous());
    }

    public function actionPcApprove($DRS_NO)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$model = $this->findModel($DRS_NO);

    	$user_info = $this->getUser(\Yii::$app->user->identity->username, \Yii::$app->user->identity->name);

    	$model->REQUEST_STAGE = 2;
    	$model->PC_APPROVE_ID = $user_info['id'];
    	$model->PC_APPROVE_NAME = $user_info['name'];
    	$model->PC_APPROVE_DATETIME = date('Y-m-d H:i:s');
    	$model->PC_APPROVE_STATUS = 'C';

    	if (!$model->save()) {
    		return json_encode($model->errors);
    	}

    	return $this->redirect(Url::previous());
    }

    public function actionWhApprove($DRS_NO)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$model = $this->findModel($DRS_NO);

    	$user_info = $this->getUser(\Yii::$app->user->identity->username, \Yii::$app->user->identity->name);

    	$model->REQUEST_STAGE = 3;
    	$model->WH_APPROVE_ID = $user_info['id'];
    	$model->WH_APPROVE_NAME = $user_info['name'];
    	$model->WH_APPROVE_DATETIME = date('Y-m-d H:i:s');
    	$model->WH_APPROVE_STATUS = 'C';

    	if (!$model->save()) {
    		return json_encode($model->errors);
    	}

    	return $this->redirect(Url::previous());
    }

    public function updateStock($model)
    {
    	$TAG_SLIP = '000000';
		$SEQ_ID = 0;
		$NO = '000';
		$STATUS = 'SUPPLEMENT';

		$params = [
			':ITEM' => $model->ITEM,
			':ITEM_DESC' => $model->ITEM_DESC,
			':UM' => $model->UM,
			':OUT_QTY' => $model->NG_QTY,
			':TAG_SLIP' => $TAG_SLIP, //ok
			':SEQ_ID' => $SEQ_ID, //ok
			':SLIP_REF' => $model->DRS_NO,
			':NO' => $NO, //ok
			':LOC' => $model->NG_LOC,
			':LOC_DESC' => $model->NG_LOC_DESC,
			':POST_DATE' => $model->PULLED_UP_DATETIME,
			':USER_ID' => $model->PULLED_UP_ID,
			':USER_DESC' => $model->PULLED_UP_NAME,
			':STATUS' => $STATUS, //ok
			':NOTE' => $NOTE,
		];
		$sql = "{CALL MATERIAL_OUT_INTERFACE(:ITEM, :ITEM_DESC, :UM, :OUT_QTY, :TAG_SLIP, :SEQ_ID, :SLIP_REF, :NO, :LOC, :LOC_DESC, :POST_DATE, :USER_ID, :USER_DESC, :STATUS, :NOTE)}";

		$error_msg = null;
		try {
		    $result = \Yii::$app->db_wsus->createCommand($sql, $params)->execute();
		} catch (Exception $ex) {
			$error_msg = $ex->getMessage();
			//return $ex->getMessage();
		}
		return $error_msg;
    }

    public function actionPulledUp($DRS_NO)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$model = $this->findModel($DRS_NO);

    	$user_info = $this->getUser(\Yii::$app->user->identity->username, \Yii::$app->user->identity->name);

    	$model->REQUEST_STAGE = 4;
    	$model->PULLED_UP_ID = $user_info['id'];
    	$model->PULLED_UP_NAME = $user_info['name'];
    	$model->PULLED_UP_DATETIME = date('Y-m-d H:i:s');
    	$model->PULLED_UP_STATUS = 'C';
    	$model->REQUEST_STATUS = 'C';

    	if (!$model->save()) {
    		return json_encode($model->errors);
    	}

    	$error_msg = $this->updateStock($model);
		if ($error_msg != null) {
			\Yii::$app->session->setFlash("danger", "Stock Update Error : " . $error_msg);
		}
		\Yii::$app->session->setFlash("success", "Stock Update...");

    	return $this->redirect(Url::previous());
    }

    protected function getUser($username, $name)
    {
    	$user_id = $username;
    	$user_name = $name;
    	$tmp_karyawan = Karyawan::find()
    	->where([
    		'OR',
    		['NIK' => $username],
    		['NIK_SUN_FISH' => $username],
    	])
    	->one();

    	if ($tmp_karyawan) {
    		$user_id = $tmp_karyawan->NIK_SUN_FISH;
    		$user_name = $tmp_karyawan->NAMA_KARYAWAN;
    	}

    	return [
    		'id' => $user_id,
    		'name' => $user_name
    	];
    }

    protected function findModel($DRS_NO)
	{
		if (($model = DrsTbl::findOne($DRS_NO)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}