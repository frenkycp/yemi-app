<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\AssetTblSearch;
use app\models\AssetTbl;
use app\models\AssetLocTbl;
use app\models\CostCenter;

/**
* This is the class for controller "AssetTblController".
*/
class AssetTblController extends \app\controllers\base\AssetTblController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	/**
	* Lists all AssetTbl models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new AssetTblSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$department_arr = ArrayHelper::map(AssetTbl::find()->select('DISTINCT(department_pic)')->orderBy('department_pic ASC')->all(), 'department_pic', 'department_pic');

		$jenis_arr = ArrayHelper::map(AssetTbl::find()->select('DISTINCT(jenis)')->where('jenis IS NOT NULL')->orderBy('jenis ASC')->all(), 'jenis', 'jenis');

		$asset_category_arr = ArrayHelper::map(AssetTbl::find()->select('DISTINCT(asset_category)')->where('asset_category IS NOT NULL')->orderBy('asset_category ASC')->all(), 'asset_category', 'asset_category');

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'department_arr' => $department_arr,
		    'jenis_arr' => $jenis_arr,
		    'asset_category_arr' => $asset_category_arr,
		]);
	}

	public function actionUpdate($asset_id)
	{
		$model = $this->findModel($asset_id);

		if ($model->load($_POST)) {
			date_default_timezone_set('Asia/Jakarta');
			$model->qr = $model->asset_id;
			$model->LAST_UPDATE = date('Y-m-d H:i:s');

			if ($model->LOC != '' && $model->LOC != null) {
				$tmp_asset_loc = AssetLocTbl::find()->where(['LOC' => $model->LOC])->one();
				$model->location = $tmp_asset_loc->LOC_DESC;
				$model->loc_type = $tmp_asset_loc->LOC_TYPE;
				$model->area = $tmp_asset_loc->LOC_AREA;
			} else {
				$model->location = null;
				$model->loc_type = null;
				$model->area = null;
			}

			if ($model->cost_centre != '' && $model->cost_centre != null) {
				$tmp_cost_center = CostCenter::find()->where([
					'CC_ID' => $model->cost_centre
				])->one();
				$model->department_pic = $model->cost_centre;
				$model->department_name = $tmp_cost_center->CC_GROUP;
				$model->section_name = $tmp_cost_center->CC_DESC;
			}
			if (!$model->save()) {
				return json_encode($model->errors);
			}
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}
