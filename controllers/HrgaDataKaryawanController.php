<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

use app\models\Karyawan;
use app\models\search\HrgaDataKaryawanSearch;

/**
* This is the class for controller "HrgaDataKaryawanController".
*/
class HrgaDataKaryawanController extends \app\controllers\base\HrgaDataKaryawanController
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	/**
	* Lists all Karyawan models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new HrgaDataKaryawanSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$departemen_dropdown = ArrayHelper::map(Karyawan::find()->select('DISTINCT(DEPARTEMEN)')->where('DEPARTEMEN IS NOT NULL')->orderBy('DEPARTEMEN')->all(), 'DEPARTEMEN', 'DEPARTEMEN');
		$section_dropdown = ArrayHelper::map(Karyawan::find()->select('DISTINCT(SECTION)')->where('SECTION IS NOT NULL')->orderBy('SECTION')->all(), 'SECTION', 'SECTION');
		$sub_section_dropdown = ArrayHelper::map(Karyawan::find()->select('DISTINCT(SUB_SECTION)')->where('SUB_SECTION IS NOT NULL')->orderBy('SUB_SECTION')->all(), 'SUB_SECTION', 'SUB_SECTION');

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'departemen_dropdown' => $departemen_dropdown,
		    'section_dropdown' => $section_dropdown,
		    'sub_section_dropdown' => $sub_section_dropdown,
		]);
	}

}
