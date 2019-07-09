<?php

namespace app\controllers;

use app\models\GoMachine;
use yii\helpers\Url;

/**
* This is the class for controller "GoMachineController".
*/
class GoMachineController extends \app\controllers\base\GoMachineController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionOrder($id)
	{
		$model = $this->findModel($id);

		$sql = "{CALL CALL_GO_MACHINE(:id, :req_user_id)}";
		// passing the params into to the sql query
		$params = [
			':id' => $id,
			':req_user_id' => \Yii::$app->user->identity->username,
		];
		// execute the sql command
		try {
		    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
		    \Yii::$app->session->setFlash("success", 'Order Number ' . $result['slip_id'] . ' was created. (Machine : ' . $result['item_desc'] . ', Model : ' . $result['model'] . ', Driver : ' . $result['GOJEK_ID'] . ' - ' . $result['GOJEK_DESC'] . ')');
		} catch (Exception $ex) {
			\Yii::$app->session->setFlash("danger", 'Order Failed : ' . $ex->getMessage());
		}
		return $this->redirect(Url::previous());
	}

	function actionOrderItem($id)
    {
    	$model = GoMachine::find()->where([
    		'id' => $id
    	])->one();

    	try {
			if ($model->load(\Yii::$app->request->post())) {
				$request_date = \Yii::$app->request->post('dp_1');
				$color = \Yii::$app->request->post('model_color');
				$sql = "{CALL CALL_GO_MACHINE2(:id, :req_user_id, :request_date, :color)}";
				$params = [
					':id' => $id,
					':req_user_id' => \Yii::$app->user->identity->username,
					':request_date' => $request_date,
					':color' => $color
				];
				//\Yii::$app->session->setFlash("success", 'Order for : ' . $request_date . ', Color : ' . $color . ', Machine ID : ' . $model->mesin_id);
				/**/try{
					$result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
		    		\Yii::$app->session->setFlash("success", 'Order Number ' . $result['slip_id'] . ' was created. (Machine : ' . $result['item_desc'] . ', Model : ' . $result['model'] . ', Driver : ' . $result['GOJEK_ID'] . ' - ' . $result['GOJEK_DESC'] . ')');
				} catch (\Exception $e) {
					$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
					\Yii::$app->session->setFlash("danger", 'Order Failed : ' . $msg);
				}
				
				return $this->redirect(Url::previous());
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}

    	return $this->renderAjax('order-item', [
    		'model' => $model
    	]);
    }
}
