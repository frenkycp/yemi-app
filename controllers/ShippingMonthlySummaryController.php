<?php

namespace app\controllers;

use app\models\ShippingMonthlySummary;
    use app\models\search\ShippingMonthlySummarySearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class ShippingMonthlySummaryController extends \app\controllers\base\ShippingMonthlySummaryController
{
	public function actionCreate()
	{
		$model = new ShippingMonthlySummary;

		try {
			if ($model->load($_POST) && $model->save()) {
				return $this->redirect(Url::previous());
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}
}
