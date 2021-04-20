<?php

namespace app\controllers;

use app\models\InjMachineTbl;
use app\models\search\InjMachineTblSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\InjMoldingTbl;
use app\models\Karyawan;

class InjMachineTblController extends \app\controllers\base\InjMachineTblController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new InjMachineTblSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionUpdate($MACHINE_ID)
	{
		$model = $this->findModel($MACHINE_ID);
		$old_molding_id = $model->MOLDING_ID;

		if ($model->load($_POST)) {
			$tmp_id = \Yii::$app->user->identity->username;
			$tmp_name = \Yii::$app->user->identity->name;
			$model->UPDATE_BY_ID = $tmp_id;
			$model->UPDATE_BY_NAME = $tmp_name;

			$tmp_user = Karyawan::find()->where([
				'OR',
				['NIK' => $tmp_id],
				['NIK_SUN_FISH' => $tmp_id]
			])->one();

			if ($tmp_user) {
				$model->UPDATE_BY_ID = $tmp_user->NIK_SUN_FISH;
				$model->UPDATE_BY_NAME = $tmp_user->NAMA_KARYAWAN;
			}
			$model->UPDATE_DATETIME = date('Y-m-d H:i:s');
			
			if ($old_molding_id != '' || $old_molding_id != null) {
                $tmp_old_molding = InjMoldingTbl::findOne($old_molding_id);
                $tmp_old_molding->MACHINE_ID = $tmp_old_molding->MACHINE_DESC = null;
                $tmp_old_molding->MOLDING_STATUS = 0;
                if (!$tmp_old_molding->save()) {
                    return json_encode($tmp_old_molding->errors);
                }
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
