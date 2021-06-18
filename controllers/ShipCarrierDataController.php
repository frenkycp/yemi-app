<?php

namespace app\controllers;

use app\models\ShipLiner;
    use app\models\search\ShipCarrierDataSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use yii\helpers\Json;
use yii\httpclient\Client;

class ShipCarrierDataController extends \app\controllers\base\ShipCarrierDataController
{
	public function actionIndex()
	{
	    $searchModel  = new ShipCarrierDataSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		if (\Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $id = \Yii::$app->request->post('editableKey');
            $model = ShipLiner::findOne(['SEQ' => $id]);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=> '' , 'message' => '']);

            $posted = current($_POST['ShipLiner']);
            $post = ['ShipLiner' => $posted];

            if ($model->load($post)) {
                $model->save();
            }
            
            echo $out;
            return;
        }

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionCreate()
	{
		$model = new ShipLiner;

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
