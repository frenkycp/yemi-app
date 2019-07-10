<?php
namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\GojekOrderTbl;
use yii\web\Controller;

class GoMachineDriverJobController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
    	$model = GojekOrderTbl::find()
    	->where([
    		'source' => 'MCH',
    		'STAT' => 'O',
    		//'GOJEK_ID' => \Yii::$app->user->identity->username,
    	])
    	->orderBy('request_date')
    	->all();

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'model' => $model,
		]);
    }

    public function actionStart($slip_id)
    {
    	$sql = "{CALL CALL_GOJEK_MACHINE_START(:slip_id, :start_nik)}";
		// passing the params into to the sql query
		$params = [
			':slip_id' => $slip_id,
			':start_nik' => \Yii::$app->user->identity->username,
		];
		// execute the sql command
		try {
		    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
		    \Yii::$app->session->setFlash("success", $result['hasil']);
		} catch (Exception $ex) {
			$response = [
				'success' => false,
				'message' => 'Order failed. ' . $ex->getMessage(),
			];
			\Yii::$app->session->setFlash("danger", 'Order Failed : ' . $ex->getMessage());
		}
		return $this->redirect(Url::previous());
    }

    public function actionEnd($slip_id)
    {
    	$sql = "{CALL CALL_GOJEK_MACHINE_FINISHED(:slip_id, :finished_nik)}";
		// passing the params into to the sql query
		$params = [
			':slip_id' => $slip_id,
			':finished_nik' => \Yii::$app->user->identity->username,
		];
		// execute the sql command
		try {
		    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
		    \Yii::$app->session->setFlash("success", $result['hasil']);
		} catch (Exception $ex) {
			$response = [
				'success' => false,
				'message' => 'Order failed. ' . $ex->getMessage(),
			];
			\Yii::$app->session->setFlash("danger", 'Order Failed : ' . $ex->getMessage());
		}
		return $this->redirect(Url::previous());
    }
}