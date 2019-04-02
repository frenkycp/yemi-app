<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\ClinicDataSearch;
use app\models\KlinikInput;
use yii\helpers\Json;

/**
* This is the class for controller "ClinicDataController".
*/
class ClinicDataController extends \app\controllers\base\ClinicDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	/**
	* Lists all KlinikInput models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new ClinicDataSearch;

	    $searchModel->input_date = date('Y-m-d');
        if (\Yii::$app->request->post('input_date') !== null) {
            $searchModel->input_date = Yii::$app->request->post('input_date');
        }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		if (\Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $pk = \Yii::$app->request->post('editableKey');
            $model = KlinikInput::findOne(['pk' => $pk]);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            $posted = current($_POST['KlinikInput']);
            $post = ['KlinikInput' => $posted];

            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();
                /*$output = '';

                if (isset($posted['unloading_time'])) {
                    $output = $model->unloading_time;
                }

                $out = Json::encode(['output'=>$output, 'message'=>'']);*/
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	/**
	* Creates a new KlinikInput model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	* @return mixed
	*/
	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new KlinikInput;

		try {
			if ($model->load($_POST)) {
				$model->masuk = date('H:i:s');
				if ($model->save()) {
					return $this->redirect(['view', 'pk' => $model->pk]);
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
}
