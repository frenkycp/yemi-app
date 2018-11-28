<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\AssetTblSearch;
use app\models\AssetTbl;

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
}
