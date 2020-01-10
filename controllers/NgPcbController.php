<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\ProdNgDataSearch;
use app\models\ProdNgData;
use app\models\NgPcbModel;
use app\models\ProdNgCategory;
use app\models\SernoMaster;
use app\models\Karyawan;

/**
 * 
 */
class NgPcbController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex($value='')
	{
		$searchModel  = new ProdNgDataSearch;
		$searchModel->loc_id = 'WM01';
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function getDocumentNo($post_date)
	{
		$total_today = ProdNgData::find()
		->where([
			'loc_id' => 'WM01',
			'post_date' => $post_date
		])
		->count();
		$total_today++;
		$document_no = 'PCB' . date('Ymd') . str_pad($total_today, 3, '0', STR_PAD_LEFT);
		return $document_no;
	}

	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new NgPcbModel;
		$model->post_date = date('Y-m-d');
		$model->created_time = date('Y-m-d H:i:s');
		$model->loc_id = 'WM01';
		$model->ng_qty = 1;
		$model->created_by_id = strtoupper(\Yii::$app->user->identity->username);
		$model->created_by_name = strtoupper(\Yii::$app->user->identity->name);

		try {
			if ($model->load($_POST)) {
				$model->period = date('Ym');
				$model->document_no = $this->getDocumentNo($model->post_date);
				$serno_master = SernoMaster::find()->where([
					'gmc' => $model->gmc_no
				])->one();
				$model->gmc_model = $serno_master->model;
				$model->gmc_color = $serno_master->color;
				$model->gmc_dest = $serno_master->dest;
				$model->gmc_line = $serno_master->line;
				$model->gmc_desc = $serno_master->description;

				$detected_karyawan = Karyawan::find()->where(['NIK_SUN_FISH' => $model->detected_by_id])->one();
				$model->detected_by_name = $detected_karyawan->NAMA_KARYAWAN;

				$ng_karyawan = Karyawan::find()->where(['NIK_SUN_FISH' => $model->emp_id])->one();
				$model->emp_name = $ng_karyawan->NAMA_KARYAWAN;

				$created_karyawan = Karyawan::find()->where([
					'OR',
					['NIK_SUN_FISH' => \Yii::$app->user->identity->username],
					['NIK' => \Yii::$app->user->identity->username]
				])->one();
				$model->created_by_id = $created_karyawan->NIK_SUN_FISH;
				$model->created_by_name = $created_karyawan->NAMA_KARYAWAN;

				$ng_category = ProdNgCategory::find()->where(['id' => $model->ng_category_id])->one();
				$model->ng_category_desc = $ng_category->category_name;
				$model->ng_category_detail = $ng_category->category_detail;

				$pcb_split_arr = explode(' | ', $model->pcb_id);
				$model->pcb_id = $pcb_split_arr[0];
				$model->pcb_name = $pcb_split_arr[1];

				$model->ng_detail = strtoupper($model->ng_detail);
				$model->part_desc = strtoupper($model->part_desc);
				$model->ng_location = strtoupper($model->ng_location);

				$part_desc_split = explode(' | ', $model->part_desc);
				if (count($part_desc_split) >= 2) {
					$model->part_no = $part_desc_split[0];
					$model->part_desc = $part_desc_split[1];
				}

				if ($model->save()) {
					return $this->redirect(Url::previous());
				} else {
					return json_encode($model->errors());
				}
				
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}

	public function actionView($id)
	{
		\Yii::$app->session['__crudReturnUrl'] = Url::previous();
		Url::remember();
		Tabs::rememberActiveState();

		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	public function actionUpdate($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);
		if ($model->part_no != null) {
			$model->part_desc = $model->part_no . ' | ' . $model->part_desc;
		}
		$model->pcb_id = $model->pcb_id . ' | ' . $model->pcb_name;

		if ($model->load($_POST)) {
			$serno_master = SernoMaster::find()->where([
				'gmc' => $model->gmc_no
			])->one();
			$model->gmc_model = $serno_master->model;
			$model->gmc_color = $serno_master->color;
			$model->gmc_dest = $serno_master->dest;
			$model->gmc_line = $serno_master->line;
			$model->gmc_desc = $serno_master->description;

			$detected_karyawan = Karyawan::find()->where(['NIK_SUN_FISH' => $model->detected_by_id])->one();
			$model->detected_by_name = $detected_karyawan->NAMA_KARYAWAN;

			if ($model->ng_cause_category == 'MAN') {
				$ng_karyawan = Karyawan::find()->where(['NIK_SUN_FISH' => $model->emp_id])->one();
				$model->emp_name = $ng_karyawan->NAMA_KARYAWAN;
			} else {
				$model->emp_id = $model->emp_name = null;
			}
			

			$model->updated_time = date('Y-m-d H:i:s');
			$updated_karyawan = Karyawan::find()->where([
				'OR',
				['NIK_SUN_FISH' => \Yii::$app->user->identity->username],
				['NIK' => \Yii::$app->user->identity->username]
			])->one();
			$model->updated_by_id = $updated_karyawan->NIK_SUN_FISH;
			$model->updated_by_name = $updated_karyawan->NAMA_KARYAWAN;

			$ng_category = ProdNgCategory::find()->where(['id' => $model->ng_category_id])->one();
			$model->ng_category_desc = $ng_category->category_name;
			$model->ng_category_detail = $ng_category->category_detail;

			$pcb_split_arr = explode(' | ', $model->pcb_id);
			$model->pcb_id = $pcb_split_arr[0];
			$model->pcb_name = $pcb_split_arr[1];

			$model->ng_detail = strtoupper($model->ng_detail);
			$model->part_desc = strtoupper($model->part_desc);
			$model->ng_location = strtoupper($model->ng_location);

			$part_desc_split = explode(' | ', $model->part_desc);
			if (count($part_desc_split) >= 2) {
				$model->part_no = $part_desc_split[0];
				$model->part_desc = $part_desc_split[1];
			} else {
				$model->part_no = null;
			}

			if ($model->save()) {
				return $this->redirect(Url::previous());
			} else {
				return json_encode($model->errors);
			}
			
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	protected function findModel($id)
	{
		if (($model = NgPcbModel::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

}