<?php
namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\search\GoMachineOrderSearch;
use app\models\GojekOrderTbl;
use yii\web\Controller;

class GoMachineOrderController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$searchModel  = new GoMachineOrderSearch;
	    $searchModel->source = 'MCH';
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
    }


	/**
	* Deletes an existing GojekOrderTbl model.
	* If deletion is successful, the browser will be redirected to the 'index' page.
	* @param integer $id
	* @return mixed
	*/
	public function actionDelete($slip_id)
	{
		try {
			$this->findModel($slip_id)->delete();
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			\Yii::$app->getSession()->addFlash('error', $msg);
			return $this->redirect(Url::previous());
		}

		// TODO: improve detection
		$isPivot = strstr('$slip_id',',');
		if ($isPivot == true) {
			return $this->redirect(Url::previous());
		} elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
			Url::remember(null);
			$url = \Yii::$app->session['__crudReturnUrl'];
			\Yii::$app->session['__crudReturnUrl'] = null;

			return $this->redirect($url);
		} else {
			return $this->redirect(['index']);
		}
	}

	/**
	* Finds the GojekOrderTbl model based on its primary key value.
	* If the model is not found, a 404 HTTP exception will be thrown.
	* @param integer $id
	* @return GojekOrderTbl the loaded model
	* @throws HttpException if the model cannot be found
	*/
	protected function findModel($slip_id)
	{
		if (($model = GojekOrderTbl::find()->where(['slip_id' => $slip_id])->one()) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}