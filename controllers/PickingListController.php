<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use yii\web\Controller;
use app\models\Karyawan;
use app\models\SapPickingList;

class PickingListController extends Controller
{
	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('picking_list_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = "picking-list\login";

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
                $session['picking_list_user'] = $karyawan->NIK_SUN_FISH;
                $session['picking_list_nik'] = $karyawan->NIK;
                $session['picking_list_name'] = $karyawan->NAMA_KARYAWAN;
                $session['picking_list_cc_id'] = $karyawan->CC_ID;
                $session['picking_list_department'] = $karyawan->DEPARTEMEN;
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
        if ($session->has('picking_list_user')) {
            $session->remove('picking_list_user');
            $session->remove('picking_list_name');
            $session->remove('picking_list_cc_id');
            $session->remove('picking_list_department');
        }

        return $this->redirect(['login']);
    }

	public function actionIndex()
	{
		$session = \Yii::$app->session;
        if (!$session->has('picking_list_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['picking_list_user'];
		$this->layout = 'picking-list/main';
		return $this->render('index');
	}

	public function actionUpdate()
	{
		$session = \Yii::$app->session;
        if (!$session->has('picking_list_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['picking_list_user'];
        $name = $session['picking_list_name'];
		$this->layout = 'picking-list/main';

		$model = new \yii\base\DynamicModel([
            'barcode'
        ]);
        $model->addRule(['barcode'], 'required')
        ->addRule(['barcode'], 'string');

        $total_setlist = $total_open = $total_close = 0;
        $setlist_data = $setlist_no = null;
        //return $nik . $name;
        if ($model->load($_GET)) {
        	if ($model->barcode == '' || $model->barcode == null) {
        		return $this->render('update', [
					'model' => $model,
					'total_setlist' => $total_setlist,
					'total_open' => $total_open,
					'total_close' => $total_close,
				]);
        	}
        	$tmp_setlist = SapPickingList::findOne($model->barcode);
        	if (!$tmp_setlist) {
        		\Yii::$app->session->setFlash('warning', 'Barcode not found...!');
        	} else {
        		$sql = "{CALL UPDATE_PICKING_LIST_TEST(:barcode, :USER_ID, :USER_DESC)}";
                $params = [
                    ':barcode' => $model->barcode,
                    ':USER_ID' => $nik,
                    ':USER_DESC' => $name,
                ];

                try {
                    $result = \Yii::$app->db_wsus->createCommand($sql, $params)->execute();
                    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
                } catch (Exception $ex) {
                    \Yii::$app->session->addFlash('danger', "Error : $ex");
                    return $this->render('update', [
						'model' => $model,
						'total_setlist' => $total_setlist,
						'total_open' => $total_open,
						'total_close' => $total_close,
						'setlist_data' => $setlist_data,
						'setlist_no' => $setlist_no,
					]);
                }

        		$tmp_total = SapPickingList::find()
	        	->select([
	        		'total_setlist' => 'SUM(CASE WHEN wh_valid = \'Y\' AND status = \'C\' THEN 1 ELSE 0 END)',
	        		'total_open' => 'SUM(CASE WHEN wh_valid = \'Y\' AND status = \'C\' AND hand_scan IS null THEN 1 ELSE 0 END)',
	        		'total_close' => 'SUM(CASE WHEN wh_valid = \'Y\' AND status = \'C\' AND hand_scan = \'Y\' THEN 1 ELSE 0 END)',
	        	])
	        	->where([
	        		'set_list_no' => $tmp_setlist->set_list_no
	        	])
	        	->one();

	        	$total_setlist = $tmp_total->total_setlist;
	        	$total_open = $tmp_total->total_open;
	        	$total_close = $tmp_total->total_close;

	        	$setlist_no = $tmp_setlist->set_list_no;

	        	$setlist_data = SapPickingList::find()
	        	->where([
	        		'set_list_no' => $tmp_setlist->set_list_no,
	        		'wh_valid' => 'Y',
	        		'status' => 'C'
	        	])
	        	->andWhere('hand_scan IS NULL')
	        	->all();

	        	\Yii::$app->session->setFlash('success', 'Barcode ' . $model->barcode . ' update success...');
        	}
        	
        }
        $model->barcode = null;

		return $this->render('update', [
			'model' => $model,
			'total_setlist' => $total_setlist,
			'total_open' => $total_open,
			'total_close' => $total_close,
			'setlist_data' => $setlist_data,
			'setlist_no' => $setlist_no,
		]);
	}

	public function actionPrintSummary($schedule_id, $department_name)
	{
		$session = \Yii::$app->session;
        if (!$session->has('picking_list_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['picking_list_user'];
		$this->layout = 'clean';

		$summary_data = AssetStockTakeSummary::find()
        ->where(['schedule_id' => $schedule_id, 'department_name' => $department_name])
        ->orderBy('department_name')
        ->one();

		return $this->render('print-summary', [
			'summary_data' => $summary_data,
			'department_name' => $department_name,
		]);
	}

	public function actionProgress()
	{
		$session = \Yii::$app->session;
        if (!$session->has('picking_list_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['picking_list_user'];
		$this->layout = 'fixed-asset/main';
		date_default_timezone_set('Asia/Jakarta');

		$model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        $data_completion = $tmp_data = $tmp_data_section_open = $tmp_data_section_close = $data_section = $section_categories = [];
        $total_ng = $total_no_label = $total_propose_scrap = 0;
        $tmp_summary = null;
        if ($model->load($_GET)) {
        	$tmp_schedule = AssetStockTakeScheduleView::find()->where(['schedule_id' => $model->period])->one();
        	$total_ng = $tmp_schedule->total_ng;
        	$total_no_label = $tmp_schedule->total_no_label;
        	$total_propose_scrap = $tmp_schedule->total_propose_scrap;
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

        	//by section
        	$tmp_asset_log = AssetLogView::find()
        	->select([
        		'cost_centre', 'CC_DESC',
        		'total_open' => 'SUM(CASE WHEN schedule_status = \'O\' THEN 1 ELSE 0 END)',
        		'total_close' => 'SUM(CASE WHEN schedule_status = \'C\' THEN 1 ELSE 0 END)',
        		'total' => 'COUNT(*)'
        		//'total_open' => 'COUNT(*)'
        	])
        	->where([
	        	//'schedule_status' => 'O',
	        	'schedule_id' => $model->period
	        ])
	        ->andWhere('cost_centre IS NOT NULL')
	        ->groupBy('cost_centre, CC_DESC')
	        ->orderBy('CC_DESC')
	        ->all();

	        foreach ($tmp_asset_log as $key => $value) {
	        	$section_categories[] = $value->CC_DESC;
	        	$tmp_data_section_open[] = [
	        		'y' => (int)$value->total_open,
	        		'url' => Url::to(['asset-log', 'schedule_id' => $model->period, 'schedule_status' => 'O', 'cost_centre' => $value->cost_centre]),
	        	];
	        	$tmp_data_section_close[] = [
	        		'y' => (int)$value->total_close,
	        		'url' => Url::to(['asset-log', 'schedule_id' => $model->period, 'schedule_status' => 'C', 'cost_centre' => $value->cost_centre]),
	        	];
	        }

	        //summary
	        $tmp_summary = AssetStockTakeSummary::find()
	        ->where(['schedule_id' => $model->period])
	        ->orderBy('department_name')
	        ->all();
        }

        $data_section = [
        	[
        		'name' => 'OPEN',
        		'data' => $tmp_data_section_open,
        		'color' => new JsExpression('Highcharts.getOptions().colors[8]'),
        	],
        	[
        		'name' => 'CLOSE',
        		'data' => $tmp_data_section_close,
        		'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
        	],
        ];

        $data_completion[] = [
        	'name' => 'Percentage',
        	'data' => $tmp_data,
        	
        ];

        $period_arr = ArrayHelper::map(AssetStockTakeScheduleView::find()->orderBy('end_date DESC, start_date DESC')->all(), 'schedule_id', 'period');

		return $this->render('progress', [
			'model' => $model,
			'period_arr' => $period_arr,
			'data_completion' => $data_completion,
			'total_ng' => $total_ng,
			'total_no_label' => $total_no_label,
			'total_propose_scrap' => $total_propose_scrap,
			'section_categories' => $section_categories,
			'data_section' => $data_section,
			'summary_data' => $tmp_summary,
		]);
	}

	public function actionData()
	{
		$session = \Yii::$app->session;
        if (!$session->has('picking_list_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['picking_list_user'];
		$this->layout = 'fixed-asset/main';
		date_default_timezone_set('Asia/Jakarta');

		\Yii::$app->session->setFlash("warning", "This options is temporarily disabled...");
		return $this->redirect(['index']);

	    $searchModel  = new FixAssetDataSearch;
	    //$searchModel->department_pic = \Yii::$app->session['picking_list_cc_id'];
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

	public function actionGetImagePreview($asset_id, $schedule_id)
	{
		//return \Yii::$app->urlManager->createUrl('uploads/NG_MNT/' . $urutan . '.jpg');
		//$src = \Yii::$app->request->BaseUrl . '/uploads/NG_MNT/' . $urutan . '.jpg';
		//$src = \Yii::$app->basePath. '\uploads\NG_MNT\\' . $urutan . '.jpg';
		$src = Html::img(\Yii::getAlias("@web/uploads/ASSET_IMG/") . $model->schedule_id . '/' . $model->asset_id . '.jpg', ['width' => '100%']);
		$tmp_item = AssetLogView::find()
		->where([
			'asset_id' => $asset_id,
			'schedule_id' => $schedule_id
		])
		->one();
		//return $src;
		return '<div class="text-center"><span><b>' . $tmp_item->computer_name . '</b></span><br/>' . Html::img(\Yii::getAlias("@web/uploads/ASSET_IMG/") . $tmp_item->schedule_id . '/' . $tmp_item->asset_id . '.jpg',
			[
				'width' => '100%',
				'alt' => $tmp_item->asset_id . '.jpg not found.'
			]) . '</div>';
	}

	public function actionStockTake($asset_id = '', $trans_id = null)
	{
		$session = \Yii::$app->session;
        if (!$session->has('picking_list_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['picking_list_user'];
        $name = $session['picking_list_name'];

		$this->layout = 'fixed-asset/main';
		date_default_timezone_set('Asia/Jakarta');

		//\Yii::$app->session->setFlash("warning", "This options is temporarily disabled...");
		//return $this->redirect(['index']);


		$fixed_asset_data = $this->findModel($asset_id);
		$model = new AssetLogTbl;
		if ($trans_id != null) {
			$model = AssetLogTbl::find()->where(['trans_id' => $trans_id])->one();
			// if ($model->schedule_status == 'C') {
			// 	\Yii::$app->session->setFlash("warning", "Stock take for asset ID : $model->asset_id had been done by $model->user_id - $model->user_desc on $model->posting_date");
			// 	return $this->redirect(Url::previous());
			// }
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
		                    ImageFile::imagine_resize($filePath);
		                    $log_folder = \Yii::getAlias("@app/web/uploads/ASSET_IMG/" . $model->schedule_id . '/');
		                    if (!file_exists($log_folder)) {
		                    	mkdir($log_folder);
		                    }
		                    copy($filePath, $log_folder . $new_filename);

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
        if (!$session->has('picking_list_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['picking_list_user'];
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
