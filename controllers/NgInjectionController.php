<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\ProdNgDataSearch;
use app\models\ProdNgData;
use app\models\NgInjectionModel;
use app\models\ProdNgCategory;
use app\models\SernoMaster;
use app\models\Karyawan;

class NgInjectionController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex($value='')
	{
		$searchModel  = new ProdNgDataSearch;
		$searchModel->loc_id = ['WI01', 'WI02', 'WI03'];
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
		date_default_timezone_set('Asia/Jakarta');
		$model = new NgInjectionModel;
		$model->post_date = date('Y-m-d');

		try {
			if ($model->load($_POST)) {
				$inj_line_arr = \Yii::$app->params['ng_inj_line_dropdown'];
				$model->loc_id = $inj_line_arr[$model->line];

				if ($model->save()) {
					return $this->redirect(Url::previous());
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

	public function actionUpdate($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);
		if ($model->part_no != null) {
			$model->part_desc = $model->part_no . ' | ' . $model->part_desc;
		}
		$model->pcb_id = $model->pcb_id . ' | ' . $model->pcb_name;

		if ($model->load($_POST)) {
			$inj_line_arr = \Yii::$app->params['ng_inj_line_dropdown'];
			$model->loc_id = $inj_line_arr[$model->line];

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

	public function actionNextAction($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);

		$model_action = new \yii\base\DynamicModel([
	        'countermeasure'
	    ]);
	    $model_action->addRule(['countermeasure'], 'required');
	    $model_action->countermeasure = $model->next_action;

		if ($model_action->load(\Yii::$app->request->post())) {
			$model->next_action = $model_action->countermeasure;
			
			if (!$model->save()) {
				return json_encode($model->errors);
			}
			
			return $this->redirect(Url::previous());
		} else {
			return $this->renderAjax('next-action', [
				'model' => $model,
				'model_action' => $model_action,
			]);
		}
	}

	protected function findModel($id)
	{
		if (($model = NgInjectionModel::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

}