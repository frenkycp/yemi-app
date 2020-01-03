<?php

namespace app\controllers;

use app\models\search\MitaUrlSearch;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\MitaUrl;

class MitaUrlController extends \app\controllers\base\MitaUrlController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
	    $searchModel  = new MitaUrlSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionCreate()
	{
		$model = new MitaUrl;

		try {
			if ($model->load($_POST)) {
				$tmp_url = MitaUrl::find()->where(['url' => $model->url])->one();
				if ($tmp_url) {
					\Yii::$app->session->setFlash("danger", "Url already exist ...");
				} else {
					if ($model->save()) {
						return $this->redirect(Url::previous());
					} else {
						return json_encode($model->errors);
					}
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

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST)) {
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
}
