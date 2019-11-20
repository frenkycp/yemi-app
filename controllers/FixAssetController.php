<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\FixAssetDataSearch;
use app\models\search\AssetLogTblSearch;
use app\models\AssetTbl;
use app\models\Karyawan;
use app\models\AssetLocTbl;
use app\models\AssetLogTbl;
use app\models\AssetDtrTbl;

class FixAssetController extends \app\controllers\base\FixAssetController
{
	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('fix_asset_user')) {
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
                $session['fix_asset_user'] = $model->username;
                $session['fix_asset_name'] = $karyawan->NAMA_KARYAWAN;
                $session['fix_asset_cc_id'] = $karyawan->CC_ID;
                $session['fix_asset_department'] = $karyawan->DEPARTEMEN;
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
        if ($session->has('fix_asset_user')) {
            $session->remove('fix_asset_user');
            $session->remove('fix_asset_name');
            $session->remove('fix_asset_cc_id');
            $session->remove('fix_asset_department');
        }

        return $this->redirect(['login']);
    }
	public function actionIndex()
	{
		$session = \Yii::$app->session;
        if (!$session->has('fix_asset_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['fix_asset_user'];
		$this->layout = 'fixed-asset/main';
		return $this->render('index');
	}
	public function actionData()
	{
		$session = \Yii::$app->session;
        if (!$session->has('fix_asset_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['fix_asset_user'];
		$this->layout = 'fixed-asset/main';
	    $searchModel  = new FixAssetDataSearch;
	    //$searchModel->department_pic = \Yii::$app->session['fix_asset_cc_id'];
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$dropdown_type = ArrayHelper::map(AssetTbl::find()
		->select([
			'jenis'
		])
		->where([
			'FINANCE_ASSET' => 'Y'
		])
		->andWhere('jenis IS NOT NULL')
		->groupBy('jenis')
		->orderBy('jenis')
		->all(), 'jenis', 'jenis');

		$dropdown_loc = ArrayHelper::map(AssetLocTbl::find()
		->orderBy('LOC_DESC')
		->all(), 'fullDesc', 'fullDesc');

		return $this->render('data', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'dropdown_type' => $dropdown_type,
		    'dropdown_loc' => $dropdown_loc,
		]);
	}

	public function actionStockTake($asset_id = '')
	{
		$session = \Yii::$app->session;
        if (!$session->has('fix_asset_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['fix_asset_user'];
        $name = $session['fix_asset_name'];

		$this->layout = 'fixed-asset/main';
		$fixed_asset_data = $this->findModel($asset_id);
		$model = new AssetLogTbl;
		//$model->from_loc = $model->to_loc = $fixed_asset_data->location;
		$model->from_loc = $fixed_asset_data->location;
		$model->NBV = $fixed_asset_data->NBV;
		$model->trans_type = 'PI';
		$model->posting_date = date('Y-m-d');
		$model->asset_id = $fixed_asset_data->asset_id;
		$model->computer_name = $fixed_asset_data->computer_name;
		$model->user_id = $nik;
		$model->user_desc = $name;
		$model->note = $fixed_asset_data->note;
		$model->propose_scrap = $model->propose_scrap_dd = 'N';

		$asset_dtr = AssetDtrTbl::find()
		->where([
			'faid' => $asset_id
		])
		->orderBy('subexp')
		->all();

		if ($model->load($_POST)) {
			if ($model->to_loc != '' && $model->to_loc != null) {
				$fixed_asset_data->location = $model->to_loc;
			} else {
				$model->to_loc = '-';
			};
			$fixed_asset_data->status = $model->status;
			$fixed_asset_data->label = $model->label;
			$fixed_asset_data->propose_scrap = $model->propose_scrap;
			$fixed_asset_data->NBV = $model->NBV;

			if ($model->save()) {
				if (!$fixed_asset_data->save()) {
					return json_encode($fixed_asset_data->errors);
				}
			} else {
				return json_encode($model->errors);
			}

			return $this->redirect(Url::previous());
		}

		return $this->render('stock-take', [
			'fixed_asset_data' => $fixed_asset_data,
			'model' => $model,
			'asset_dtr' => $asset_dtr,
		]);
	}

	public function actionAssetLog()
	{
		$session = \Yii::$app->session;
        if (!$session->has('fix_asset_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['fix_asset_user'];
		$this->layout = 'fixed-asset/main';
	    $searchModel  = new AssetLogTblSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('asset-log', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	/*public function actionCreate()
	{
		$this->layout = 'fixed-asset/main';
		$model = new AssetTbl;

		try {
			if ($model->load($_POST) && $model->save()) {
				return $this->redirect(['view', 'asset_id' => $model->asset_id]);
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}

	public function actionUpdate($asset_id)
	{
		$this->layout = 'fixed-asset/main';
		$model = $this->findModel($asset_id);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}*/
}
