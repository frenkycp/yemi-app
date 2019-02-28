<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\WipHdrDtrSearch;
use app\models\WipPlanActualReport;
use app\models\WipHdrDtr;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\HttpException;
use yii\helpers\Json;

class FaWipDataController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    function actionIndex()
    {
    	$searchModel  = new WipHdrDtrSearch;
    	$searchModel->child_analyst = 'WF01';
    	$searchModel->stage = '01-CREATED';
    	$searchModel->period = date('Ym');
    	if (\Yii::$app->request->get('period') !== null) {
			$searchModel->period = \Yii::$app->request->get('period');
		}
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

    	return $this->render('index', [
    		'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
    	]);
    }

    function actionCancel()
    {
    	$model = new \yii\base\DynamicModel([
	        'slip_id'
	    ]);
	    $model->addRule(['slip_id'], 'required');

	    if($model->load(\Yii::$app->request->post())){
	        $user_id = \Yii::$app->user->identity->username;

	        $sql = "{CALL WIP_04_HAND_OVER_CANCEL_FA(:slip_id, :USER_ID)}";
			$params = [
				':slip_id' => $model->slip_id,
				':USER_ID' => $user_id
			];

			try{
				$result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
				if (strpos($result['hasil'], 'BERHASIL') !== false) {
					//$pesan_arr = explode('-', $result['hasil']);
					\Yii::$app->session->setFlash("success", "Slip Number $model->slip_id was canceled by User ID : $user_id");
				} else {
					\Yii::$app->session->setFlash("danger", $result['hasil']);
				}
				
			} catch (\Exception $e) {
				$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
				\Yii::$app->session->setFlash("danger", $msg);
			}

	        return $this->redirect(Url::previous());
	    }

	    return $this->renderAjax('cancel', [
    		'model' => $model
    	]);
    }

    function actionComplete($slip_id)
    {
    	$model = WipHdrDtr::find()->where([
    		'slip_id' => $slip_id
    	])->one();
    	$model->summary_qty = (int)$model->balance_by_day + (int)$model->act_qty;

    	try {
			if ($model->load(\Yii::$app->request->post())) {
				$handover_qty = $model->act_qty;
				$delay_category = $model->delay_category;
				$delay_detail = $model->delay_detail;
				$user_id = \Yii::$app->user->identity->username;
				//$user_id = '150826';
				$sql = "{CALL WIP_04_HAND_OVER_NOT_FULL_FA(:slip_id, :hand_over_qty, :USER_ID, :delay_category, :delay_detail)}";
				$params = [
					':slip_id' => $model->slip_id,
					':hand_over_qty' => $handover_qty,
					':USER_ID' => $user_id,
					':delay_category' => $delay_category,
					':delay_detail' => $delay_detail
				];
				try{
					$result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
					if (strpos($result['hasil'], 'BERHASIL') !== false) {
						//$pesan_arr = explode('-', $result['hasil']);
						\Yii::$app->session->setFlash("success", "Slip Number $model->slip_id was completed. Qty = $handover_qty/$model->summary_qty. User ID : $user_id");
					} else {
						\Yii::$app->session->setFlash("danger", $result['hasil']);
					}
					
				} catch (\Exception $e) {
					$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
					\Yii::$app->session->setFlash("danger", $msg);
				}
				
				return $this->redirect(Url::previous());
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		$model->complete_qty = $model->summary_qty;

    	return $this->renderAjax('complete', [
    		'model' => $model
    	]);
    }
}