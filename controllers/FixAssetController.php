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
use app\models\ImageFile;
use app\models\AssetStockTakeSchedule;
use yii\web\UploadedFile;
use yii\web\JsExpression;

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

	public function actionProgress()
	{
		$session = \Yii::$app->session;
        if (!$session->has('fix_asset_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['fix_asset_user'];
		$this->layout = 'fixed-asset/main';
		date_default_timezone_set('Asia/Jakarta');

		$model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        $data_completion = $tmp_data = [];
        $total_ng = $total_no_label = $total_propose_scrap = 0;
        if ($model->load($_GET)) {
        	$tmp_schedule = AssetStockTakeSchedule::find()->where(['schedule_id' => $model->period])->one();
        	$total_ng = $tmp_schedule->total_ng;
        	$total_no_label = $tmp_schedule->total_label_n;
        	$total_propose_scrap = $tmp_schedule->total_scrap_y;
        	$tmp_data = [
        		[
        			'name' => 'OPEN',
        			'y' => (int) $tmp_schedule->total_open,
        			'url' => Url::to(['asset-log', 'schedule_id' => $model->period, 'schedule_status' => 'O']),
        			'color' => new JsExpression('Highcharts.getOptions().colors[8]'),
        		],
        		[
        			'name' => 'CLOSE',
        			'y' => (int) $tmp_schedule->total_close,
        			'url' => Url::to(['asset-log', 'schedule_id' => $model->period, 'schedule_status' => 'C']),
        			'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
        		],
        	];
        }

        $data_completion[] = [
        	'name' => 'Percentage',
        	'data' => $tmp_data
        ];

        $period_arr = ArrayHelper::map(AssetStockTakeSchedule::find()->orderBy('end_date DESC, start_date DESC')->all(), 'schedule_id', 'period');

		return $this->render('progress', [
			'model' => $model,
			'period_arr' => $period_arr,
			'data_completion' => $data_completion,
			'total_ng' => $total_ng,
			'total_no_label' => $total_no_label,
			'total_propose_scrap' => $total_propose_scrap,
		]);
	}

	public function actionData()
	{
		$session = \Yii::$app->session;
        if (!$session->has('fix_asset_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['fix_asset_user'];
		$this->layout = 'fixed-asset/main';
		date_default_timezone_set('Asia/Jakarta');
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

	public function actionStockTake($asset_id = '', $trans_id = null)
	{
		$session = \Yii::$app->session;
        if (!$session->has('fix_asset_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['fix_asset_user'];
        $name = $session['fix_asset_name'];

		$this->layout = 'fixed-asset/main';
		date_default_timezone_set('Asia/Jakarta');

		$fixed_asset_data = $this->findModel($asset_id);
		$model = new AssetLogTbl;
		if ($trans_id != null) {
			$model = AssetLogTbl::find()->where(['trans_id' => $trans_id])->one();
			if ($model->schedule_status == 'C') {
				\Yii::$app->session->setFlash("warning", "Stock take for asset ID : $model->asset_id had been done by $model->user_id - $model->user_desc on $model->posting_date");
				return $this->redirect(Url::previous());
			}
		}
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
			$tmp_karyawan = Karyawan::find()->where([
				'OR',
				['NIK' => $nik],
				['NIK_SUN_FISH' => $nik]
			])->one();
			
			if ($tmp_karyawan->NIK_SUN_FISH != null) {
				$model->schedule_status = 'C';
				if ($model->to_loc != '' && $model->to_loc != null) {
					$tmp_asset_loc = AssetLocTbl::find()->where(['LOC' => $model->to_loc])->one();
					$fixed_asset_data->LOC = $model->to_loc;
					$fixed_asset_data->location = $tmp_asset_loc->LOC_DESC;
					$model->to_loc = $tmp_asset_loc->LOC_DESC;
				} else {
					$model->to_loc = NULL;
				};
				$fixed_asset_data->status = $model->status;
				$fixed_asset_data->label = $model->label;
				$fixed_asset_data->propose_scrap = $model->propose_scrap;
				$fixed_asset_data->NBV = $model->NBV;

				$model->upload_file = UploadedFile::getInstance($model, 'upload_file');
		        $new_filename = $asset_id . '.' . $model->upload_file->extension;

		        if ($model->validate()) {
		        	if ($model->upload_file) {
		        		$filePath = \Yii::getAlias("@app/web/uploads/ASSET_IMG/") . $new_filename;
		        		if ($model->upload_file->saveAs($filePath)) {
		                    //ImageFile::resize_crop_image($filePath, $filePath, 50, 800);
		                    $fixed_asset_data->primary_picture = $asset_id;
		                }
		                
		        	}
		        }

				if ($model->save()) {
					if (!$fixed_asset_data->save()) {
						return json_encode($fixed_asset_data->errors);
					}
					if ($model->schedule_id != null) {
						$tmp_schedule = AssetStockTakeSchedule::find()->where(['schedule_id' => $model->schedule_id])->one();
						$tmp_schedule->total_open = $tmp_schedule->total_open - 1;
						$tmp_schedule->total_close = $tmp_schedule->total_close + 1;
						$tmp_schedule->update_by_id = $nik;
						$tmp_schedule->update_by_name = $name;
						$tmp_schedule->update_time = date('Y-m-d H:i:s');

						if ($model->status == 'OK') {
							$tmp_schedule->total_ok = $tmp_schedule->total_ok + 1;
						} else {
							$tmp_schedule->total_ng = $tmp_schedule->total_ng + 1;
						}

						if ($model->label == 'Y') {
							$tmp_schedule->total_label_y = $tmp_schedule->total_label_y + 1;
						} else {
							$tmp_schedule->total_label_n = $tmp_schedule->total_label_n + 1;
						}

						if ($model->propose_scrap == 'Y') {
							$tmp_schedule->total_scrap_y = $tmp_schedule->total_scrap_y + 1;
						} else {
							$tmp_schedule->total_scrap_n = $tmp_schedule->total_scrap_n + 1;
						}

						if (!$tmp_schedule->save()) {
							return json_encode($tmp_schedule->errors);
						}
					}
				} else {
					return json_encode($model->errors);
				}
			} else {
				\Yii::$app->getSession()->setFlash('error', 'Your NIK Sunfish not found. Please contact administrator');
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
		date_default_timezone_set('Asia/Jakarta');

	    $searchModel  = new AssetLogTblSearch;

	    if(\Yii::$app->request->get('label') !== null)
	    {
	    	$searchModel->label = \Yii::$app->request->get('label');
	    }
	    if(\Yii::$app->request->get('propose_scrap') !== null)
	    {
	    	$searchModel->propose_scrap = \Yii::$app->request->get('propose_scrap');
	    }
	    if(\Yii::$app->request->get('schedule_id') !== null)
	    {
	    	$searchModel->schedule_id = \Yii::$app->request->get('schedule_id');
	    }
	    if(\Yii::$app->request->get('status') !== null)
	    {
	    	$searchModel->status = \Yii::$app->request->get('status');
	    }
	    if(\Yii::$app->request->get('cost_centre') !== null)
	    {
	    	$searchModel->cost_centre = \Yii::$app->request->get('cost_centre');
	    }
	    if(\Yii::$app->request->get('schedule_status') !== null)
	    {
	    	$searchModel->schedule_status = \Yii::$app->request->get('schedule_status');
	    }
	    $searchModel->trans_type = 'PI';

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

		return $this->render('asset-log', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'dropdown_type' => $dropdown_type,
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
