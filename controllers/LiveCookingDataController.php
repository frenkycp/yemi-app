<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\LiveCookingDataSearch;
use app\models\LiveCookingRequest;
use app\models\LiveCookingBgt;
use app\models\Karyawan;

/**
* This is the class for controller "LiveCookingDataController".
*/
class LiveCookingDataController extends \app\controllers\base\LiveCookingDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new LiveCookingDataSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionCancel($seq)
	{
		$model = $this->findModel($seq);
		$user_id = \Yii::$app->user->identity->username;
		$user_data = Karyawan::find()
		->where([
			'OR',
			['NIK' => $user_id],
			['NIK_SUN_FISH' => $user_id],
		])
		->one();
		$pesan = [
            'category' => 0,
            'data' => '',
        ];
		if ($user_data->NIK != null) {
			$sql = "{CALL LIVE_COOKING_REQUEST_CANCEL(:NIK, :cc, :post_date, :USER_ID, :USER_DESC)}";
			$params = [
				':NIK' => $model->NIK,
				':cc' => $model->cc,
				':post_date' => $model->post_date,
				':USER_ID' => $user_data->NIK_SUN_FISH,
				':USER_DESC' => $user_data->NAMA_KARYAWAN,
			];
			try {
			    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
			    if (strpos($result['hasil'], 'TIDAK TERSEDIA')) {
                    $pesan['category'] = 2;
                    $pesan['data'] = 'YOUR ORDER NOT FOUND, '. $tmp_karyawan->NAMA_KARYAWAN;
                    \Yii::$app->session->setFlash('warning', 'Data not found...');
                } else {
                	\Yii::$app->session->setFlash('success', 'Request has been canceled...');
                }
			    
			} catch (Exception $ex) {
				echo 'Caught exception: ',  $ex->getMessage(), "\n";
			}
		}
		return $this->redirect(Url::previous());
	}

	public function actionCreate()
	{
		$model = new LiveCookingRequest;
		$model->post_date = date('Y-m-d');

		try {
			if ($model->load($_POST)) {
				$tmp_budget = LiveCookingBgt::find()->where([
					'cc' => $model->cc,
				])
				->andWhere([
					'AND',
					['<=', 'start_date', $model->post_date],
					['>=', 'end_date', $model->post_date]
				])
				->one();
				if ($tmp_budget->id == null) {
					\Yii::$app->session->setFlash("warning", 'There is no budget. Please contact administrator...');
				} else {
					if (($tmp_budget->balance - count($model->employee)) >= 0) {
						$user_id = \Yii::$app->user->identity->username;
						$user_data = Karyawan::find()
						->where([
							'OR',
							['NIK' => $user_id],
							['NIK_SUN_FISH' => $user_id],
						])
						->one();
						if ($user_data->NIK != null) {
							$sql = "{CALL LIVE_COOKING_REQUEST_INSERT(:NIK, :cc, :DATE, :USER_ID, :USER_DESC)}";
							foreach ($model->employee as $key => $value) {
								$params = [
									':NIK' => $value,
									':cc' => $model->cc,
									':DATE' => $model->post_date,
									':USER_ID' => $user_data->NIK_SUN_FISH,
									':USER_DESC' => $user_data->NAMA_KARYAWAN,
								];
								try {
								    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
								    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
								} catch (Exception $ex) {
									echo 'Caught exception: ',  $ex->getMessage(), "\n";
								}
							}
							return $this->redirect(Url::previous());
						} else {
							\Yii::$app->session->setFlash("danger", 'Your NIK is not registered...');
						}
						
					} else {
						$budget_type = '';
						if ($tmp_budget->type == 'D') {
							$budget_type = 'Daily';
						}
						if ($tmp_budget->type == 'W') {
							$budget_type = 'Weekly';
						}
						\Yii::$app->session->setFlash("warning", 'Over Budget. Your ' . $budget_type . ' balance : ' . $tmp_budget->balance . ', your request : ' . count($model->employee));
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
}
