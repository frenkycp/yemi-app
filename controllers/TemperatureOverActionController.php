<?php

namespace app\controllers;

use app\models\TemperatureOverAction;
    use app\models\search\TemperatureOverActionSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class TemperatureOverActionController extends \app\controllers\base\TemperatureOverActionController
{
	public function actionAdd($post_date, $emp_id, $emp_name, $shift, $old_temp, $check_time)
	{
		$this->layout = 'clean';
		$id = $post_date . '_' . $emp_id;
		$tmp_over_action = TemperatureOverAction::findOne($id);

		if ($tmp_over_action->ID) {
			return $this->render('add-complete', [
				'panel_class' => 'panel-danger',
				'status' => 'Action Failed...!',
				'message' => 'Data already updated. You can close this tab.',
			]);
		}
		
		$model = new TemperatureOverAction;
		$model->POST_DATE = $post_date;
		$model->EMP_ID = $emp_id;
		$model->EMP_NAME = $emp_name;
		$model->SHIFT = $shift;
		$model->OLD_TEMPERATURE = $model->NEW_TEMPERATURE = $old_temp;
		$model->LAST_CHECK = $check_time;
		$model->ID = $id;

		try {
			if ($model->load($_POST)) {
				
				if ($model->save()) {
					return $this->render('add-complete', [
						'panel_class' => 'panel-success',
						'status' => 'Action Updated...!',
						'message' => 'Action has been updated. You can close this tab.',
					]);
				} else {
					return json_encode($model->errors);
				}
				
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('add', ['model' => $model]);
	}

	protected function findModel($ID)
	{
		if (($model = TemperatureOverAction::findOne($ID)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
