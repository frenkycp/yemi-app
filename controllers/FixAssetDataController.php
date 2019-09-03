<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\FixAssetDataSearch;
use app\models\AssetTbl;
use app\models\AssetLocTbl;
use app\models\AssetLogTbl;

class FixAssetDataController extends \app\controllers\base\FixAssetDataController
{
	public function actionIndex()
	{
	    $searchModel  = new FixAssetDataSearch;
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

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'dropdown_type' => $dropdown_type,
		    'dropdown_loc' => $dropdown_loc,
		]);
	}

	public function actionStockTake($asset_id = '')
	{
		$fixed_asset_data = $this->findModel($asset_id);
		$model = new AssetLogTbl;
		$model->from_loc = $model->to_loc = $fixed_asset_data->location;

		if ($model->load($_POST)) {
			# code...
		}

		return $this->render('stock-take', [
			'fixed_asset_data' => $fixed_asset_data,
			'model' => $model,
		]);
	}
}
